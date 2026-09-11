# Specifiche per Vibe Coding — UnicoAIAct

Questo documento è la guida di dominio da fornire a un assistente AI (o a un
developer che lavora "a braccio" con un assistente AI) prima di chiedere
nuove funzionalità su questa app. Non sostituisce `CLAUDE.md` (convenzioni
tecniche Laravel/Filament/Boost): lo completa con il contesto di **cosa fa
l'applicazione, perché, e quali vincoli non sono negoziabili**.

Regola generale per il vibe coding su questo progetto: **è un software di
compliance legale, non un CRUD qualunque**. Ogni record scritto (audit,
sigillo, incidente, valutazione di rischio) può finire davanti a un
Organismo Notificato, all'AI Office o a un giudice. Prompt vaghi tipo
"aggiungi una feature X" vanno sempre completati con "e mantieni la
tracciabilità/immodificabilità dei dati esistenti", altrimenti il modello
tenderà a semplificare e a rompere silenziosamente le garanzie legali.

## 1. Cosa fa l'app

UnicoAIAct è un registro di conformità all'**EU AI Act** (Reg. UE 2024/1689)
per organizzazioni che sviluppano o utilizzano sistemi di intelligenza
artificiale. È organizzato attorno a 4 "pilastri" normativi, ciascuno
mappato su un gruppo di modelli/risorse Filament:

| Pilastro | Modelli | Scopo normativo |
|---|---|---|
| 1. Classificazione del rischio | `AiSystem`, `AiModel`, `RiskAssessment` | Inventario dei sistemi IA (incluso "Shadow AI"), classificazione in `prohibited/high/limited/minimal`, verifica Allegato III |
| 2. Impatto sui diritti fondamentali | `FriaAssessment` | FRIA ex Art. 27, con eventuale collegamento a una DPIA GDPR esterna |
| 3. Supervisione umana | campi su `AiSystem` (`human_oversight_type`, `has_kill_switch`, `kill_switch_procedure`) | Human-in-the-loop / on-the-loop / in-command, kill switch |
| 4. Trasparenza, monitoraggio, registrazione | `BiasTest`, `EsgAiMetric`, `AiIncident`, registrazione banca dati UE su `AiSystem` | Bias/drift testing, impatto ambientale, incident reporting all'autorità |

Trasversali a tutti i pilastri:

- **`ComplianceFramework` / `FrameworkRequirement` / `Audit` / `AuditAnswer`**:
  motore di audit generico, non limitato all'AI Act (può ospitare ISO 42001,
  NIST AI RMF, GDPR...). `AiComplianceCalculatorService` calcola la
  percentuale di conformità di un `Audit` filtrando i requisiti applicabili
  al livello di rischio del sistema.
- **`PqcSignature`**: sigillo di integrità **WORM** (Write-Once-Read-Many)
  apposto su record approvati (oggi: `AiSystem`), per garantire che
  un'approvazione di compliance non sia alterabile a posteriori. Vedi §4.
- **`Organization`**: tenant nominale (azienda, ente pubblico, agenzia di
  consulenza) — vedi §5 per lo stato reale dell'isolamento multi-tenant.
- **Spatie Activitylog** su (quasi) tutti i modelli: è il registro delle
  attività, cioè la prova storica di chi ha fatto cosa e quando. Non va mai
  bypassato per le operazioni che cambiano lo stato di conformità.

## 2. Stack tecnico (verificare sempre con `composer show --direct`)

- Laravel 13, PHP 8.4
- Filament v5 (pannello admin su `/admin`)
- Pest v4 per i test
- `spatie/laravel-activitylog` v5, `spatie/laravel-medialibrary` v11
- `barryvdh/laravel-dompdf` per l'export PDF del "Kit Compliance"

Le guideline Laravel Boost (`CLAUDE.md`) restano valide e vincolanti: usare
i comandi Artisan/Filament per generare file, non assumere API di versioni
diverse da quelle installate, `search-docs` prima di codice che dipende da
comportamenti versione-specifici.

## 3. Regole di dominio non negoziabili

Quando si chiede a un assistente AI di implementare una feature, includere
sempre questi vincoli nel prompt (o verificarli in review) perché un
modello lasciato libero tende a ignorarli per semplicità:

1. **Non inventare riferimenti normativi.** Articoli dell'AI Act, soglie,
   scadenze, obblighi devono venire da una fonte verificata (testo del
   regolamento, documentazione ufficiale), mai generati "a memoria" da un
   LLM e scritti come se fossero certi. Se il codice o l'interfaccia cita un
   articolo (es. "Art. 50"), deve essere verificabile da un umano prima del
   merge.
2. **Terminologia crittografica accurata.** Non chiamare "post-quantistico"
   (PQC) un meccanismo che non lo è. Il sigillo WORM attuale è un
   HMAC-SHA3-512 con chiave simmetrica (integrità + autenticazione, non
   firma a chiave pubblica né resistenza quantistica reale). Se in futuro si
   vuole una vera firma PQC (es. ML-DSA/Dilithium, ML-KEM/Kyber), va
   implementata con una libreria dedicata e la label `hash_algorithm` deve
   riflettere l'algoritmo reale. Non lasciare che un'etichetta UI o un nome
   di colonna sovra-dichiari le garanzie di sicurezza: è materiale che un
   auditor esterno può contestare.
3. **Nessun segreto nel codice sorgente.** Chiavi di firma, secret HMAC,
   credenziali: sempre `env()`/`config()`, mai stringhe letterali. Il fix
   applicato in questa sessione (`PQC_WORM_SECRET_KEY`) è il pattern di
   riferimento: config dedicata, validazione esplicita se mancante, errore
   *prima* di mutare qualunque stato.
4. **Consistenza transazionale sulle operazioni di sigillo/approvazione.**
   Un record non deve mai poter risultare "approvato" senza il relativo
   sigillo, né "sigillato" senza il corrispondente log di attività. Le
   azioni che toccano più tabelle correlate (stato + sigillo + log) vanno
   avvolte in `DB::transaction()`.
5. **Audit trail sempre presente.** Ogni mutazione rilevante per la
   compliance (creazione/modifica di `AiSystem`, `RiskAssessment`,
   `Audit`, `AiIncident`, sigilli) deve passare da `LogsActivity` o da una
   chiamata esplicita ad `activity()`. Non usare `->withoutLogging()` su
   percorsi di dominio se non per import/seeding esplicitamente marcato come
   tale.
6. **Immutabilità del WORM.** Una volta creato, un `PqcSignature` non va mai
   aggiornato né cancellato da codice applicativo. Se serve invalidare un
   sigillo, si crea un nuovo evento (es. "revoca"), non si modifica quello
   esistente.
7. **I punteggi di conformità sono calcolati, non editabili a mano.**
   `score_percentage` e `status` su `Audit` sono derivati da
   `AiComplianceCalculatorService::calculate()`. Non aggiungere campi form
   che permettano di scriverli direttamente: romperebbe la tracciabilità
   del calcolo.

## 4. Sicurezza — stato attuale e cosa verificare prima di ogni feature

- Il sigillo WORM richiede `PQC_WORM_SECRET_KEY` in `.env` (mai in git). In
  produzione deve essere un valore lungo, casuale, diverso per ambiente, e
  idealmente ruotabile (oggi non c'è rotazione: un cambio di chiave rende
  non ri-verificabili i sigilli storici salvo conservarne la chiave usata al
  momento — da tenere presente se si implementa una verifica del sigillo).
- **Non esiste ancora un meccanismo di verifica del sigillo** (nessun
  endpoint/azione che ricalcoli l'HMAC e lo confronti con quello salvato).
  Un sigillo che nessuno verifica ha valore probatorio debole: è un gap da
  colmare prima di presentare il WORM come garanzia "a valore legale" in
  produzione.
- **Isolamento multi-tenant assente.** `Organization` esiste come colonna
  (`ai_systems.organization_id`), ma:
  - `User` non ha alcun legame con `Organization` (né colonna né relazione);
  - nessuna Policy Laravel/Filament è definita in `app/`;
  - nessuna risorsa Filament applica uno scope su `getEloquentQuery()` per
    limitare i dati all'organizzazione dell'utente loggato.
  In pratica **qualsiasi utente autenticato sul pannello `/admin` vede e può
  modificare i dati di tutte le organizzazioni**. Per un'app descritta come
  multi-tenant ("UnicoConsultant") questo è il gap più importante da
  chiudere prima di un uso reale con più clienti. Non è stato risolto in
  questa sessione perché richiede una decisione di prodotto (un utente
  appartiene a una sola organizzazione? può essere consulente su più
  organizzazioni? servono ruoli tipo "Compliance Officer" vs "Auditor" vs
  "Admin globale"?) — da chiarire con l'utente prima di implementare.
- Prima di aggiungere export, API pubbliche o report condivisibili via
  link, verificare che non si stia bypassando lo scoping per
  organizzazione (quando verrà introdotto) o l'autenticazione del pannello.

## 5. Modello dati — regole di business da rispettare

- `risk_level` ammessi: `prohibited`, `high`, `limited`, `minimal` (vedi
  migrazione `create_ai_compliance_tables`). Un sistema `prohibited` non
  dovrebbe poter essere "approvato" — se si aggiunge questa validazione,
  farlo a livello di form/azione, non solo di UI (disabilitare il bottone
  non basta: validare anche nell'`action()`).
- `FrameworkRequirement.applicable_risk_levels` è un array JSON di livelli
  di rischio; se vuoto, il requisito è considerato applicabile a tutti i
  livelli (vedi `AiComplianceCalculatorService`). Qualunque nuova logica di
  filtro sui requisiti deve riusare questo servizio, non duplicare la
  logica altrove.
- `Audit.score_percentage` è `non_compliant` sotto l'80% (soglia hardcoded
  in `AiComplianceCalculatorService::calculate()`). Se la soglia deve
  diventare configurabile per framework (es. ISO 42001 vs AI Act con soglie
  diverse), è un cambiamento di schema (`compliance_frameworks.threshold`),
  non solo di codice.

## 6. Convenzioni di codice specifiche del progetto

Oltre a `CLAUDE.md`:

- Testi UI, label, messaggi di log e nomi di variabili di dominio sono in
  **italiano**; nomi di classi/metodi/colonne restano in inglese. Non
  mischiare le due cose nello stesso livello (es. non tradurre nomi di
  metodi).
- Le Filament Action complesse (vedi `ApproveAndSealAction`,
  `DownloadComplianceReportAction`) vivono in
  `app/Filament/Resources/<Resource>/Actions/` come classi dedicate che
  estendono `Filament\Actions\Action`, non come closure inline nella
  Resource. Seguire questo pattern per nuove azioni non banali.
- I servizi di dominio (calcoli, orchestrazione multi-modello) vivono in
  `app/Services/` come classi invocabili, non come trait sui modelli.
- Ogni modello di dominio usa `protected $guarded = []` + cast espliciti +
  `LogsActivity` con `LogOptions::defaults()->logAll()->logOnlyDirty()`:
  è lo standard del progetto, riusarlo per nuovi modelli salvo motivo
  specifico per divergere (e in quel caso commentare il perché).

## 7. Testing

- Framework: Pest, stile "vibe coding" *deve comunque* passare da test
  reali: per questo dominio i test non sono opzionali, in particolare per:
  - logica di calcolo (`AiComplianceCalculatorService`);
  - azioni che scrivono sigilli/log (`ApproveAndSealAction` e simili);
  - qualunque validazione su stati non ammessi (es. impedire approvazione
    di un sistema `prohibited`, se implementata).
- Quando si aggiunge una condizione di errore (es. "configurazione
  mancante"), aggiungere sempre il test del percorso infelice, non solo del
  percorso felice — vedi il test aggiunto in questa sessione per la chiave
  PQC mancante come riferimento di stile.
- `php artisan test --compact` per la suite completa prima di considerare
  chiusa una feature; il filtro su singolo file/`--filter` durante lo
  sviluppo.

## 8. Backlog noto (da affrontare con l'utente, non a sorpresa)

Elenco dei gap identificati in questa sessione, in ordine di impatto:

1. **Isolamento multi-tenant e autorizzazione** (§4) — nessuna Policy,
   nessuno scope per organizzazione. Blocca un uso multi-cliente sicuro.
2. **Verifica del sigillo WORM** — oggi si può solo creare un sigillo, non
   verificarlo. Serve un'azione "Verifica integrità" che ricalcoli l'HMAC.
3. **Rotazione della chiave PQC** — nessuna strategia per ruotare
   `PQC_WORM_SECRET_KEY` senza invalidare i sigilli storici (es. versionare
   la chiave: salvare un `key_version` sul `PqcSignature`).
4. **Vera crittografia post-quantistica**, se il posizionamento commerciale
   richiede di poter dire davvero "PQC" (oggi è HMAC-SHA3-512 simmetrico).
5. **Soglia di conformità configurabile per framework** invece che
   hardcoded all'80% in `AiComplianceCalculatorService`.
6. **Validazione di dominio su transizioni di stato non ammesse** (es.
   sistemi `prohibited` che non dovrebbero poter essere approvati).

Quando si chiede a un assistente AI di "aggiungere una feature" su questa
app, è buona norma controllare se tocca uno di questi punti e, se sì,
chiarirlo esplicitamente nel prompt invece di lasciare che l'AI scelga da
sola come comportarsi su un gap noto.
