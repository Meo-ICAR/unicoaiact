# Graph Report - unicoaiact  (2026-10-05)

## Corpus Check
- 172 files · ~86,846 words
- Verdict: corpus is large enough that graph structure adds value.
- Unclassified: 31 file(s) not represented in the graph (top: (none) 16, .woff2 7, .css 3)

## Summary
- 5847 nodes · 18811 edges · 155 communities (123 shown, 32 thin omitted)
- Extraction: 91% EXTRACTED · 9% INFERRED · 0% AMBIGUOUS · INFERRED: 1714 edges (avg confidence: 0.85)
- Token cost: 0 input · 0 output

## Community Hubs (Navigation)
- code-editor.js
- rich-editor.js
- components/chart.js
- t
- resolve
- update
- stat/chart.js
- n
- .forEach
- AiSystem
- fromObject
- constructor
- draw
- get
- create
- _update
- BackedEnum
- markdown-editor.js
- support.js
- n
- of
- i
- .slice
- tables.js
- create
- file-upload.js
- advance
- y
- reduce
- addProseMirrorPlugins
- updateElements
- Filament\Schemas\Schema
- Filament\Tables\Table
- forward
- Cn
- parse
- te
- notifications.js
- vp
- ce
- lineAt
- find
- r
- isHorizontal
- V
- e
- components/select.js
- Illuminate\Database\Schema\Blueprint
- getContext
- Si
- buildTicks
- CreateAiSystem.php
- getDatasetMeta
- slider.js
- ir
- get
- AiComplianceSeeder.php
- e
- columns/select.js
- selectOption
- be
- _a
- Xt
- Filament\Support\Icons\Heroicon
- match
- S
- eq
- constructor
- P
- _resolveAnimations
- echo.js
- Cx
- _update
- addElementByRule
- fn
- fn
- s
- E
- sliceDoc
- Y
- filament/app.js
- dx
- fn
- AdminPanelProvider.php
- package.json
- jr
- fn
- _notify
- closeDropdown
- En
- getDatasetMeta
- parse
- AuditResource.php
- ComplianceFrameworkResource.php
- FrameworkRequirementResource.php
- FriaAssessmentResource.php
- PqcSignatureResource.php
- color-picker.js
- A
- selectOption
- date-time-picker.js
- No
- renderOptions
- r
- t
- o
- st
- N
- actions/actions.js
- Fe
- lo
- schemas.js
- bootstrap/app.php
- composer.json
- require
- require-dev
- scripts
- README.md
- config
- Vf
- TestCase
- components/actions.js
- AppServiceProvider
- psr-4
- ExampleTest
- autoload-dev
- extra
- pt
- Ae
- Controller.php

## God Nodes (most connected - your core abstractions)
1. `update()` - 149 edges
2. `constructor()` - 147 edges
3. `resolve()` - 95 edges
4. `y()` - 93 edges
5. `_update()` - 85 edges
6. `node()` - 79 edges
7. `te()` - 77 edges
8. `constructor()` - 76 edges
9. `n()` - 74 edges
10. `e()` - 71 edges

## Surprising Connections (you probably didn't know these)
- `{closure#1}()` --calls--> `User`  [EXTRACTED]
  database/seeders/AiComplianceSeeder.php → app/Models/User.php
- `{closure#1}()` --calls--> `ApproveAndSealAction`  [EXTRACTED]
  tests/Unit/ApproveAndSealActionTest.php → app/Filament/Resources/AiSystems/Actions/ApproveAndSealAction.php
- `{closure#1}()` --calls--> `DownloadComplianceReportAction`  [EXTRACTED]
  tests/Unit/DownloadComplianceReportActionTest.php → app/Filament/Resources/AiSystems/Actions/DownloadComplianceReportAction.php
- `xQ()` --indirect_call--> `ay()`  [INFERRED]
  public/js/filament/forms/components/code-editor.js → public/js/filament/forms/components/rich-editor.js
- `[x]()` --indirect_call--> `H()`  [INFERRED]
  public/js/filament/forms/components/color-picker.js → public/js/filament/forms/components/markdown-editor.js

## Import Cycles
- None detected.

## Communities (155 total, 32 thin omitted)

### Community 0 - "code-editor.js"
Cohesion: 0.01
Nodes (121): Ac(), addCompletion(), addCompletions(), addEventListener(), addNamespace(), addNamespaceObject(), addWindowListeners(), Ag() (+113 more)

### Community 1 - "rich-editor.js"
Cohesion: 0.01
Nodes (174): aa(), add(), addExtensions(), addHackNode(), addNode(), addOptions(), addTextblockHacks(), applyAspectRatio() (+166 more)

### Community 2 - "components/chart.js"
Cohesion: 0.01
Nodes (123): abutsStart(), addControllers(), addPlugins(), addScales(), alpha(), Be(), bm(), $c() (+115 more)

### Community 3 - "t"
Cohesion: 0.03
Nodes (139): aa(), acceptToken(), allows(), AQ(), atLastNode(), au(), AX(), b1() (+131 more)

### Community 4 - "resolve"
Cohesion: 0.06
Nodes (128): Ac(), addCommands(), addKeyboardShortcuts(), after(), al(), allowsMarks(), AS(), before() (+120 more)

### Community 5 - "update"
Cohesion: 0.03
Nodes (127): accept(), addChunk(), addInfoPane(), addInner(), adjust(), annotation(), blur(), bS() (+119 more)

### Community 6 - "stat/chart.js"
Cohesion: 0.03
Nodes (82): addControllers(), addPlugins(), addScales(), alpha(), applyStack(), ar(), beforeDatasetsDraw(), beforeDraw() (+74 more)

### Community 7 - "n"
Cohesion: 0.03
Nodes (125): Ad(), ao(), append(), au(), ay(), Bd(), Bg(), bt() (+117 more)

### Community 8 - ".forEach"
Cohesion: 0.03
Nodes (104): _0(), addGlobalAttributes(), addInputRules(), addMark(), addPasteRules(), addStoredMark(), af(), Ah() (+96 more)

### Community 9 - "AiSystem"
Cohesion: 0.06
Nodes (22): {closure#2}(), AiIncident, AiModel, AiSystem, Audit, AuditAnswer, BiasTest, ComplianceFramework (+14 more)

### Community 10 - "fromObject"
Cohesion: 0.03
Nodes (101): Il(), Oe(), El(), ac(), ae(), after(), ag(), Al() (+93 more)

### Community 11 - "constructor"
Cohesion: 0.04
Nodes (100): activateHover(), add(), addToSet(), applyEdits(), bf(), buildDeco(), cd(), childString() (+92 more)

### Community 12 - "draw"
Cohesion: 0.05
Nodes (97): acquireContext(), adjustHitBoxes(), Ao(), aspectRatio(), B(), bh(), calculateLabelRotation(), _calculatePadding() (+89 more)

### Community 13 - "get"
Cohesion: 0.04
Nodes (94): addBlockWidget(), addBreak(), addComposition(), addDelimiter(), addInlineWidget(), addLine(), addLineStart(), addLineStartIfNotCovered() (+86 more)

### Community 14 - "create"
Cohesion: 0.06
Nodes (91): addNodeMark(), ag(), allowedMarks(), bu(), _c(), clearIncompatible(), close(), closeFrontierNode() (+83 more)

### Community 15 - "_update"
Cohesion: 0.04
Nodes (93): addBox(), addElements(), afterBuildTicks(), afterCalculateLabelRotation(), afterDataLimits(), afterDraw(), afterFit(), afterSetDimensions() (+85 more)

### Community 16 - "BackedEnum"
Cohesion: 0.05
Nodes (28): AiIncidentResource, CreateAiIncident, EditAiIncident, ListAiIncidents, AiModelResource, CreateAiModel, EditAiModel, ListAiModels (+20 more)

### Community 17 - "markdown-editor.js"
Cohesion: 0.05
Nodes (82): Aa(), ad(), af(), ai(), al(), An(), bc(), bf() (+74 more)

### Community 18 - "support.js"
Cohesion: 0.04
Nodes (77): acquireScrollLock(), ae(), ai(), Ao(), apply(), as(), B(), close() (+69 more)

### Community 19 - "n"
Cohesion: 0.08
Nodes (83): _a(), Ae(), ar(), as(), at(), ue(), u(), ci() (+75 more)

### Community 20 - "of"
Cohesion: 0.04
Nodes (76): active(), al(), B(), baseTheme(), between(), blockTiles(), bu(), compute() (+68 more)

### Community 21 - "i"
Cohesion: 0.04
Nodes (75): ad(), ah(), applyStack(), average(), bd(), beforeLayout(), bi(), bu() (+67 more)

### Community 22 - ".slice"
Cohesion: 0.05
Nodes (73): accepts(), addAttributes(), addMaps(), addStep(), addTransform(), appendMap(), appendMapping(), appendMappingInverted() (+65 more)

### Community 23 - "tables.js"
Cohesion: 0.08
Nodes (71): Ge(), Ke(), A(), ae(), areRecordsPartiallySelected(), areRecordsSelected(), areRecordsToggleable(), B() (+63 more)

### Community 24 - "create"
Cohesion: 0.04
Nodes (72): Cl(), clone(), create(), Ct(), Dl(), dtFormatter(), Ea(), Ec() (+64 more)

### Community 25 - "file-upload.js"
Cohesion: 0.05
Nodes (52): hc(), Bp(), c(), ca(), clickPercent(), constructor(), Cp(), da() (+44 more)

### Community 26 - "advance"
Cohesion: 0.05
Nodes (62): addChild(), addGaps(), addLeafElement(), addNode(), advance(), ATXHeading(), balance(), blank() (+54 more)

### Community 27 - "y"
Cohesion: 0.11
Nodes (62): Be(), cd(), me(), Cr(), Ct(), de(), dr(), dt() (+54 more)

### Community 28 - "reduce"
Cohesion: 0.06
Nodes (61): addActions(), advanceFully(), advanceStack(), allActions(), apply(), c0(), canShift(), checkAsyncSchedule() (+53 more)

### Community 29 - "addProseMirrorPlugins"
Cohesion: 0.07
Nodes (55): addNodeView(), addProseMirrorPlugins(), Bf(), bl(), buildProps(), can(), chain(), commands() (+47 more)

### Community 30 - "updateElements"
Cohesion: 0.06
Nodes (56): addEventListener(), au(), bindResponsiveEvents(), br(), _calculateBarIndexPixels(), _calculateBarValuePixels(), calculateCircumference(), _circumference() (+48 more)

### Community 31 - "Filament\Schemas\Schema"
Cohesion: 0.07
Nodes (11): AiIncidentForm, AuditAnswerForm, AuditForm, BiasTestForm, ComplianceFrameworkForm, EsgAiMetricForm, FrameworkRequirementForm, FriaAssessmentForm (+3 more)

### Community 32 - "Filament\Tables\Table"
Cohesion: 0.09
Nodes (8): AiIncidentsTable, AiModelsTable, IncidentsRelationManager, {closure#5}(), AnswersRelationManager, BiasTestsTable, {closure#3}(), RiskAssessmentsTable

### Community 33 - "forward"
Cohesion: 0.05
Nodes (55): addActive(), addChanges(), addSelection(), Ah(), applyTransaction(), Ar(), as(), asSingle() (+47 more)

### Community 34 - "Cn"
Cohesion: 0.12
Nodes (52): Cn(), b(), Be(), Ce(), De(), dn(), _e(), Fe() (+44 more)

### Community 35 - "parse"
Cohesion: 0.06
Nodes (55): afterAutoSkip(), bs(), Bt(), buildLookupTable(), Cn(), determineDataLimits(), l(), diff() (+47 more)

### Community 36 - "te"
Cohesion: 0.05
Nodes (10): Bn(), Id(), ji(), on(), qd(), qi(), Ri(), te() (+2 more)

### Community 37 - "notifications.js"
Cohesion: 0.06
Nodes (31): actions(), button(), c(), close(), configureAnimations(), configureTransitions(), constructor(), danger() (+23 more)

### Community 38 - "vp"
Cohesion: 0.08
Nodes (48): Rd(), $a(), ak(), at(), bk(), c(), bp(), Dk() (+40 more)

### Community 39 - "ce"
Cohesion: 0.08
Nodes (47): Ac(), ao(), bl(), Cc(), ee(), ce(), Cn(), Dc() (+39 more)

### Community 40 - "lineAt"
Cohesion: 0.06
Nodes (47): activeForPoint(), addBlock(), addElement(), addLineDeco(), applyChanges(), balanced(), baseIndent(), baseIndentFor() (+39 more)

### Community 41 - "find"
Cohesion: 0.06
Nodes (43): baseDirAt(), bidiIn(), bidiSpans(), bidiSpansAt(), bP(), checkHover(), coordsAt(), coordsAtPos() (+35 more)

### Community 42 - "r"
Cohesion: 0.14
Nodes (42): ar(), c(), f(), d(), di(), g(), Hi(), I() (+34 more)

### Community 43 - "isHorizontal"
Cohesion: 0.07
Nodes (46): jo(), Ao(), bl(), buildTicks(), calculateLabelRotation(), _calculatePadding(), ci(), _computeLabelItems() (+38 more)

### Community 44 - "V"
Cohesion: 0.22
Nodes (41): b(), $c(), X(), D(), _e(), Ea(), f(), se() (+33 more)

### Community 45 - "e"
Cohesion: 0.07
Nodes (45): apply(), at(), Ba(), Bf(), Bt(), dc(), determineDataLimits(), Eh() (+37 more)

### Community 46 - "components/select.js"
Cohesion: 0.09
Nodes (33): A(), b(), Bt(), D(), E(), en(), gt(), ht() (+25 more)

### Community 47 - "Illuminate\Database\Schema\Blueprint"
Cohesion: 0.08
Nodes (24): {closure#1}(), {closure#2}(), {closure#3}(), {closure#1}(), {closure#2}(), {closure#1}(), {closure#2}(), {closure#3}() (+16 more)

### Community 48 - "getContext"
Cohesion: 0.08
Nodes (43): acquireContext(), addElements(), Ae(), bi(), Ca(), clear(), _computeGridLineItems(), _computeLabelArea() (+35 more)

### Community 49 - "Si"
Cohesion: 0.13
Nodes (41): ae(), At(), bi(), bn(), ci(), cn(), ct(), de() (+33 more)

### Community 50 - "buildTicks"
Cohesion: 0.07
Nodes (41): af(), afterAutoSkip(), buildLookupTable(), buildTicks(), count(), diff(), diffNow(), eg() (+33 more)

### Community 51 - "CreateAiSystem.php"
Cohesion: 0.08
Nodes (16): AiSystemResource, {closure#1}(), {closure#10}(), {closure#11}(), {closure#2}(), {closure#3}(), {closure#4}(), {closure#5}() (+8 more)

### Community 52 - "getDatasetMeta"
Cohesion: 0.07
Nodes (40): afterDatasetsUpdate(), An(), ar(), beforeDatasetDraw(), beforeDatasetsDraw(), beforeDraw(), _drawDataset(), _drawDatasets() (+32 more)

### Community 53 - "slider.js"
Cohesion: 0.11
Nodes (33): ar(), Be(), Ce(), De(), _e(), Ee(), er(), et() (+25 more)

### Community 54 - "ir"
Cohesion: 0.13
Nodes (34): Ft(), ir(), ce(), de(), Dt(), ee(), Et(), fe() (+26 more)

### Community 55 - "get"
Cohesion: 0.08
Nodes (35): add(), bo(), bs(), ca(), _cachedScopes(), Ch(), Ci(), datasetElementScopeKeys() (+27 more)

### Community 56 - "AiComplianceSeeder.php"
Cohesion: 0.07
Nodes (6): UserFactory, AiComplianceSeeder, {closure#1}(), ComplianceDataSeeder, ComplianceFrameworksSeeder, DatabaseSeeder

### Community 57 - "e"
Cohesion: 0.07
Nodes (34): themeClasses(), Ot(), apply(), chartOptionScopes(), constructor(), describe(), ei(), fi() (+26 more)

### Community 58 - "columns/select.js"
Cohesion: 0.09
Nodes (22): addBadgesForSelectedOptions(), addSingleBadge(), applyDisabledState(), createBadgeElement(), createRemoveButton(), disable(), E(), en() (+14 more)

### Community 59 - "selectOption"
Cohesion: 0.15
Nodes (33): addSingleSelectionDisplay(), closeDropdown(), constructor(), createOptionElement(), deferPositionDropdown(), destroy(), filterOptions(), focusNextOption() (+25 more)

### Community 60 - "be"
Cohesion: 0.07
Nodes (33): aa(), active(), ai(), _animateOptions(), ba(), be(), color(), _createAnimations() (+25 more)

### Community 61 - "_a"
Cohesion: 0.17
Nodes (32): _a(), Bi(), br(), Bt(), ca(), ct(), Dn(), Ea() (+24 more)

### Community 62 - "Xt"
Cohesion: 0.15
Nodes (32): ae(), At(), bi(), bn(), ci(), cn(), ct(), di() (+24 more)

### Community 63 - "Filament\Support\Icons\Heroicon"
Cohesion: 0.09
Nodes (9): ApproveAndSealAction, {closure#1}(), {closure#1}(), DownloadComplianceReportAction, EsgAiMetricResource, CreateEsgAiMetric, EditEsgAiMetric, ListEsgAiMetrics (+1 more)

### Community 64 - "match"
Cohesion: 0.09
Nodes (31): bd(), Bh(), clearDelayedAndroidKey(), continue(), d0(), De(), delayAndroidKey(), Dg() (+23 more)

### Community 65 - "S"
Cohesion: 0.11
Nodes (31): add(), _cachedScopes(), createResolver(), da(), drawTitle(), fr(), get(), _getAnims() (+23 more)

### Community 66 - "eq"
Cohesion: 0.10
Nodes (30): a$(), boundChange(), commit(), compare(), comparePoint(), compareRange(), eq(), findWidget() (+22 more)

### Community 67 - "constructor"
Cohesion: 0.07
Nodes (29): Bc(), bg(), chartOptionScopes(), constructor(), Cs(), data(), dg(), el() (+21 more)

### Community 68 - "P"
Cohesion: 0.09
Nodes (29): br(), buildOrUpdateControllers(), cancel(), _createDescriptors(), _descriptors(), _destroyDatasetMeta(), getController(), getElement() (+21 more)

### Community 69 - "_resolveAnimations"
Cohesion: 0.08
Nodes (28): buildOrUpdateElements(), _dataCheck(), datasetAnimationScopeKeys(), datasetElementScopeKeys(), getDataset(), getMaxOverflow(), getPadding(), getSharedOptions() (+20 more)

### Community 71 - "echo.js"
Cohesion: 0.09
Nodes (12): ar(), b(), cr(), d(), f(), Me(), P(), Pr() (+4 more)

### Community 72 - "Cx"
Cohesion: 0.10
Nodes (27): Bc(), check(), checkAttrs(), checkContent(), createChecked(), Cx(), endIndex(), getObj() (+19 more)

### Community 73 - "_update"
Cohesion: 0.12
Nodes (27): afterBuildTicks(), afterCalculateLabelRotation(), afterDataLimits(), afterFit(), afterSetDimensions(), afterTickToLabelConversion(), afterUpdate(), an() (+19 more)

### Community 74 - "addElementByRule"
Cohesion: 0.14
Nodes (25): addAll(), addDOM(), addElement(), addElementByRule(), addTextNode(), addToSet(), allowsMarkType(), closeExtra() (+17 more)

### Community 75 - "fn"
Cohesion: 0.16
Nodes (25): aa(), e(), ba(), cr(), da(), Dr(), ei(), Fi() (+17 more)

### Community 76 - "fn"
Cohesion: 0.16
Nodes (25): Ce(), de(), ei(), fn(), Ft(), gi(), Ie(), Kt() (+17 more)

### Community 77 - "s"
Cohesion: 0.10
Nodes (25): addEventListener(), bindEvents(), bindResponsiveEvents(), bindUserEvents(), _checkEventBindings(), cl(), _eventHandler(), fa() (+17 more)

### Community 78 - "E"
Cohesion: 0.11
Nodes (23): $a(), aa(), cd(), E(), ef(), getBasePosition(), getBaseValue(), getPadding() (+15 more)

### Community 79 - "sliceDoc"
Cohesion: 0.13
Nodes (22): aO(), charCategorizer(), Fc(), getCursor(), getDeco(), gT(), highlight(), Hr() (+14 more)

### Community 80 - "Y"
Cohesion: 0.15
Nodes (22): A(), An(), b(), Bt(), D(), F(), ht(), $i() (+14 more)

### Community 81 - "filament/app.js"
Cohesion: 0.12
Nodes (11): B(), close(), G(), init(), P(), setUpResizeObserver(), U(), x() (+3 more)

### Community 82 - "dx"
Cohesion: 0.18
Nodes (21): Ei(), Ba(), Bi(), Gr(), Jr(), Kr(), ls(), mr() (+13 more)

### Community 83 - "fn"
Cohesion: 0.17
Nodes (21): Ck(), De(), fn(), p(), Gh(), ip(), Ja(), Jh() (+13 more)

### Community 85 - "package.json"
Cohesion: 0.12
Nodes (17): devDependencies, concurrently, laravel-vite-plugin, tailwindcss, @tailwindcss/vite, vite, private, $schema (+9 more)

### Community 86 - "jr"
Cohesion: 0.14
Nodes (19): al(), dataset(), first(), ha(), jr(), nearest(), pathSegment(), Pn() (+11 more)

### Community 87 - "fn"
Cohesion: 0.22
Nodes (18): An(), Ce(), ei(), fn(), Ft(), Ie(), Le(), ni() (+10 more)

### Community 88 - "_notify"
Cohesion: 0.14
Nodes (18): active(), _animateOptions(), cancel(), _createAnimations(), _createDescriptors(), _d(), _descriptors(), nd() (+10 more)

### Community 89 - "closeDropdown"
Cohesion: 0.23
Nodes (17): applyDisabledState(), closeDropdown(), constructor(), destroy(), disable(), enable(), focusNextOption(), focusPreviousOption() (+9 more)

### Community 90 - "En"
Cohesion: 0.14
Nodes (16): At(), de(), dt(), Ee(), En(), Ge(), Gt(), he() (+8 more)

### Community 91 - "getDatasetMeta"
Cohesion: 0.15
Nodes (17): afterDatasetsUpdate(), getDatasetMeta(), _handleEvent(), hide(), il(), isDatasetVisible(), ni(), ps() (+9 more)

### Community 92 - "parse"
Cohesion: 0.17
Nodes (16): Bm(), eat(), err(), Hm(), n(), Im(), isInGroup(), Lm() (+8 more)

### Community 93 - "AuditResource.php"
Cohesion: 0.20
Nodes (5): AuditResource, CreateAudit, EditAudit, ListAudits, AuditsTable

### Community 94 - "ComplianceFrameworkResource.php"
Cohesion: 0.20
Nodes (5): ComplianceFrameworkResource, CreateComplianceFramework, EditComplianceFramework, ListComplianceFrameworks, ComplianceFrameworksTable

### Community 95 - "FrameworkRequirementResource.php"
Cohesion: 0.20
Nodes (5): FrameworkRequirementResource, CreateFrameworkRequirement, EditFrameworkRequirement, ListFrameworkRequirements, FrameworkRequirementsTable

### Community 96 - "FriaAssessmentResource.php"
Cohesion: 0.20
Nodes (5): FriaAssessmentResource, CreateFriaAssessment, EditFriaAssessment, ListFriaAssessments, FriaAssessmentsTable

### Community 97 - "PqcSignatureResource.php"
Cohesion: 0.20
Nodes (5): CreatePqcSignature, EditPqcSignature, ListPqcSignatures, PqcSignatureResource, PqcSignaturesTable

### Community 98 - "color-picker.js"
Cohesion: 0.14
Nodes (3): style(), update(), [x]()

### Community 99 - "A"
Cohesion: 0.19
Nodes (15): A(), As(), buildOrUpdateScales(), _computeLabelSizes(), cr(), ensureScalesHaveIDs(), fn(), getScale() (+7 more)

### Community 100 - "selectOption"
Cohesion: 0.20
Nodes (14): addBadgesForSelectedOptions(), addSingleBadge(), addSingleSelectionDisplay(), createBadgeElement(), createRemoveButton(), getLabelForSingleSelection(), getLabelsForMultipleSelection(), getSelectedOptionLabel() (+6 more)

### Community 101 - "date-time-picker.js"
Cohesion: 0.26
Nodes (8): d(), e(), i(), m(), r(), s(), t(), rr()

### Community 102 - "No"
Cohesion: 0.23
Nodes (13): addInner(), locals(), localsInner(), mapInner(), No(), Nu(), off(), on() (+5 more)

### Community 103 - "renderOptions"
Cohesion: 0.37
Nodes (13): createOptionElement(), deferPositionDropdown(), filterOptions(), handleSearch(), hideLoadingState(), openDropdown(), populateLabelRepositoryFromOptions(), positionDropdown() (+5 more)

### Community 104 - "r"
Cohesion: 0.17
Nodes (12): Be(), ei(), ii(), le(), ni(), oi(), r(), ri() (+4 more)

### Community 105 - "t"
Cohesion: 0.20
Nodes (11): di(), e(), g(), Ht(), i(), Ie(), Re(), t() (+3 more)

### Community 106 - "o"
Cohesion: 0.17
Nodes (12): ct(), Fs(), getActiveElements(), getElementsAtEventForMode(), Is(), ki(), kl(), ra() (+4 more)

### Community 107 - "st"
Cohesion: 0.24
Nodes (11): [g](), _freeze(), getAllExtensions(), Ct(), lt(), ot(), se(), st() (+3 more)

### Community 108 - "N"
Cohesion: 0.33
Nodes (11): ae(), A(), E(), at(), be(), Gt(), i(), Jt() (+3 more)

### Community 109 - "actions/actions.js"
Cohesion: 0.44
Nodes (8): closeModal(), generateModalId(), getActionNestingIndexFromModalId(), init(), openModal(), rememberPreviouslyFocusedElement(), restorePreviouslyFocusedElement(), syncActionModals()

### Community 110 - "Fe"
Cohesion: 0.20
Nodes (10): Ce(), De(), Dt(), Fe(), He(), ir(), Mt(), nr() (+2 more)

### Community 111 - "lo"
Cohesion: 0.29
Nodes (10): Km(), lo(), qm(), n(), renderSpec(), serializeFragment(), serializeMark(), serializeNode() (+2 more)

### Community 113 - "bootstrap/app.php"
Cohesion: 0.33
Nodes (3): {closure#1}(), {closure#2}(), {closure#3}()

### Community 114 - "composer.json"
Cohesion: 0.22
Nodes (8): description, keywords, license, minimum-stability, name, prefer-stable, $schema, type

### Community 115 - "require"
Cohesion: 0.22
Nodes (9): require, barryvdh/laravel-dompdf, filament/filament, filament/spatie-laravel-media-library-plugin, laravel/framework, laravel/tinker, php, spatie/laravel-activitylog (+1 more)

### Community 116 - "require-dev"
Cohesion: 0.22
Nodes (9): require-dev, fakerphp/faker, laravel/pail, laravel/pao, laravel/pint, mockery/mockery, nunomaduro/collision, pestphp/pest (+1 more)

### Community 117 - "scripts"
Cohesion: 0.22
Nodes (9): scripts, dev, post-autoload-dump, post-create-project-cmd, post-root-package-install, post-update-cmd, pre-package-uninstall, setup (+1 more)

### Community 118 - "README.md"
Cohesion: 0.25
Nodes (7): About Laravel, Agentic Development, Code of Conduct, Contributing, Learning Laravel, License, Security Vulnerabilities

### Community 119 - "config"
Cohesion: 0.29
Nodes (7): pestphp/pest-plugin, php-http/discovery, config, allow-plugins, optimize-autoloader, preferred-install, sort-packages

### Community 120 - "Vf"
Cohesion: 0.33
Nodes (7): contains(), gi(), splitAt(), toISOTime(), toMillis(), Vf(), ye()

### Community 124 - "psr-4"
Cohesion: 0.40
Nodes (5): autoload, psr-4, App\\, Database\\Factories\\, Database\\Seeders\\

### Community 129 - "autoload-dev"
Cohesion: 0.67
Nodes (3): autoload-dev, psr-4, Tests\\

### Community 130 - "extra"
Cohesion: 0.67
Nodes (3): extra, laravel, dont-discover

### Community 133 - "pt"
Cohesion: 0.67
Nodes (3): H(), ji(), pt()

### Community 134 - "Ae"
Cohesion: 0.67
Nodes (3): Ae(), Bt(), ne()

## Knowledge Gaps
- **62 isolated node(s):** `Controller`, `$schema`, `name`, `type`, `description` (+57 more)
  These have ≤1 connection - possible missing edges or undocumented components. (Counts symbols only; 850 node(s) total have ≤1 connection when file, concept and rationale nodes are included.)
- **32 thin communities (<3 nodes) omitted from report** — run `graphify query` to explore isolated nodes.

## Suggested Questions
_Questions this graph is uniquely positioned to answer:_

- **Why does `update()` connect `update` to `code-editor.js`, `rich-editor.js`, `t`, `n`, `fromObject`, `constructor`, `get`, `markdown-editor.js`, `n`, `of`, `.slice`, `reduce`, `forward`, `te`, `vp`, `lineAt`, `find`, `V`, `e`, `eq`, `echo.js`, `sliceDoc`, `dx`?**
  _High betweenness centrality (0.061) - this node is a cross-community bridge._
- **Are the 23 inferred relationships involving `update()` (e.g. with `Pr()` and `r()`) actually correct?**
  _`update()` has 23 INFERRED edges - model-reasoned connections that need verification._
- **What connects `Controller`, `$schema`, `name` to the rest of the system?**
  _62 weakly-connected nodes found - possible documentation gaps or missing edges._
- **Should `code-editor.js` be split into smaller, more focused modules?**
  _Cohesion score 0.009077259077259077 - nodes in this community are weakly interconnected._
- **Why does `_s()` connect `components/chart.js` to `rich-editor.js`, `i`?**
  _High betweenness centrality (0.043) - this node is a cross-community bridge._
- **Are the 12 inferred relationships involving `constructor()` (e.g. with `gQ()` and `Dn()`) actually correct?**
  _`constructor()` has 12 INFERRED edges - model-reasoned connections that need verification._
- **Should `rich-editor.js` be split into smaller, more focused modules?**
  _Cohesion score 0.012354790214568812 - nodes in this community are weakly interconnected._