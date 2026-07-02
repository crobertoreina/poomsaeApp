# Taekwondo Poomsae Tournament Manager — Memory Palace

## Architecture
- **PHP 8.2** MVC with custom router (`App\Core\Router`)
- **MySQL** DB via `mysqli` with singleton `Database` class
- **Base path detection**: `app/init.php` — `BASE_PATH` from `dirname($_SERVER['SCRIPT_NAME'])`, `base_url()` generates absolute URLs
- **Models**: extend `App\Core\Model` (static), each defines `$table` and `$primaryKey`
- **Controllers**: extend `App\Core\Controller` — `requireAuth()`, `json()`, `view()`, `redirect()`, `getParam()`, `getInt()`
- **Routes**: defined in `index.php` via `$router->get/post(path, [Controller::class, 'method'])`

## Authentication & Users
- **Schools** (`escuelas` table): `user_level=1`, login by email or username, hashed password
- **Judges** (`jueces` table): `user_level=2`, login by username, redirected to `/evaluacion`
- **Login order**: school first, then judge fallback
- **Session vars**: `escuela_id`, `user_level`, `escuela_nombre`/`escuela_siglas` (for schools), `juez_id`/`juez_nombre` (for judges)
- `requireAuth()` checks `array_key_exists('escuela_id', $_SESSION)` (allows 0 for judges without school)

## Tournament System
- **CRUD**: `TorneoController` — `guardar/actualizar/eliminar`, `Torneo` model
- **States**: `estado` column — 0=borrador (editable), 1=en_curso (locked+evaluation), 2=finalizado (read-only)
- **Toggle**: switch between 0↔1 via `toggleEstado`; past-date validation prevents activation
- **Finalizar**: one-way to estado=2
- **Code**: each tournament gets `POOMSAE-XXXXXX` code for school invitations
- **Judge count**: `num_jueces` column (3/5/7) configurable per tournament
- **List**: current/future tournaments in "Mis Torneos", past-dated (estado=0) in "Torneos Anteriores"

## Invitations & Multi-School
- `torneo_invitaciones` table: `(id_torneo, id_escuela, estado)` — pendiente/aceptada
- **Invite**: creator invites school → record with estado='pendiente'
- **Join**: school enters code → `aceptarPorCodigo()` creates/accepts invitation
- **Visibility**: accepted tours shown in "Torneos Invitados", pending in "🔔 Invitaciones Pendientes" with code displayed
- **Access control**: invited school only sees own participants (no other schools')

## Categories
- `torneo_categorias` table per tournament: nombre, sexo (M/F/X), edad_min/max, cinturon_min/max
- Belt colors shown as colored circles via `renderBeltDots()` JS + `beltColor()` PHP helper
- Custom dropdowns replace `<select>` for belt selection (colored dots + text)

## Participants
- `participantes` table per school: nombre, apellido, sexo, fecha_nacimiento, edad, cinturon, grado, etc.
- Added to tournaments via `torneoparticipante` junction with `id_categoria`
- UNIQUE KEY `uq_torneo_participante(idTorneo, idParticipante)`
- `ON DUPLICATE KEY UPDATE id_categoria = VALUES(id_categoria)` for category reassignment

## Poomsae Scoring (4 criteria, max 10.0)
- **Presentación** (`puntaje`): starts at 4.0, buttons ±0.1/±0.3, max 4.0, min 0
- **Fuerza/Velocidad** (`fuerza_velocidad`): slider 0–2.0, step 0.1
- **Ritmo/Tiempo** (`ritmo_tiempo`): slider 0–2.0, step 0.1
- **Expresión Energía** (`expresion_energia`): slider 0–2.0, step 0.1
- **Total**: sum of all 4 (max 10.0)
- **Scoring formula**: 3 judges = simple average; 5/7 judges = drop lowest+highest then average
- **Re-evaluation blocked**: judge cannot re-score a participant once saved
- `torneo_puntajes` UNIQUE KEY: `(id_torneo, id_participante, id_juez)` — allows same judge across different tournaments
- UNIQUE KEY on hosting: `(id_torneo, id_participante, id_juez)`

## Judge Evaluation Flow
1. Judge logs in → redirected to `/evaluacion`
2. Sees list of assigned tournaments; estado=1 clickable, estado=0/2 show 🔒
3. Selects tournament → participants grouped by category
4. Clicks participant → 4.0 display with ±buttons + 3 sliders (0–2)
5. Saves → all 4 values sent to `POST /evaluacion/guardar`
6. Evaluated participants show ✅ with score, not clickable

## Scoreboard
- **Public**: `/scoreboard?id=X` — no auth required
- **Private**: `/torneos/puntajes?id=X` — creator only, returns JSON
- **Sort**: by category then by `promedio_total` DESC (highest first)
- **Display**: medal positions (🥇🥈🥉), belt dots, sub-score breakdown (P, F/V, R/T, E), total /10

## Hosting
- **URL**: `taekapp.us.tempcloudsite.com`
- **DB**: `cattrachas_taekdb` (user=`cattrachas_taekdb`, pass=`c@r10s`, host=localhost)
- **Credentials in**: `/app/init.php` on server
- **FTP**: user=`taekapp_taekapp.us.tempcloudsite.com`, pass=`c@r10s`
- **Migration**: DB changes applied via PHP scripts uploaded temporarily then deleted
- **Known migrations**: `estado` column, `torneo_puntajes` table, UNIQUE KEY `(id_torneo,id_participante,id_juez)`, `num_jueces` column, `fuerza_velocidad/ritmo_tiempo/expresion_energia` columns

## Known Issues
- `dataB.txt` in repo root contains prod DB credentials — should be removed from VCS
- Short open tags (`<?=`) required in php.ini
- No cascade delete for `torneo_puntajes` when tournament is deleted
- Missing FK constraints on `torneo_puntajes`
- Bottom nav in `views/participantes/index.php` has dead "Jueces"/"Torneos" buttons (show alert instead of navigating)
- ServiceWorker only registered on login/register pages
- No auto-refresh on scoreboard (manual reload)
