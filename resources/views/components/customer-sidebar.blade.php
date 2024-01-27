
<div class="navbar navbar-expand">
    <div>
        <div class="p-lg-0">
            <ul class="nav menu-sidebar">
                @customerCan('read DashboardMenu')
                <li class="nav-item"><i class="icn fa-solid fa-house"></i>
                    <a href="{{ route('customer.dashboard') }}"
                    data-route="dashboard"
                    class="nav-link">Dashboard</a>
                </li>
                @endadminCan

                @adminCan('read TeilnehmerMenu')
                <li class="nav-item"><i class="icn fa-solid fa-user-group"></i><a
                        href="{{ route('admin.students.index') }}"
                        data-route="students"
                        class="nav-link">Teilnehmer</a></li>
                @endadminCan

                @adminCan('read KurseMenu')
                <li class="nav-item parent">
                    <div class="btn-toggle align-items-center rounded" data-bs-toggle="collapse"
                         data-bs-target="#kurse-collapse" aria-expanded="true">
                        <i class="icn fa-solid fa-layer-group"></i>Kurse
                    </div>
                    <div class="collapse" id="kurse-collapse">
                        <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                            <li class="nav-item"><a href="{{ route('admin.platforms.index') }}"
                                                    data-route="platforms" class="nav-link"><i
                                        class="icn fa-solid fa-desktop"></i>Kurs-Platformen</a></li>
                            <li class="nav-item"><a href="{{ route('admin.courses.index') }}"
                                        data-route="courses" class="nav-link"><i
                                        class="icn fa-solid fa-desktop"></i>Kurse</a></li>
                            <li class="nav-item"><a href="{{ route('admin.course_dates.index') }}"
                                        data-route="course_dates" class="nav-link"><i
                                        class="icn fa-solid fa-rectangle-list"></i>Kursplanung</a></li>
                            <li class="nav-item"><a href="{{ route('soon', 'Zertifikate') }}"
                                        data-route="Zertifikate" class="nav-link"><i
                                        class="icn fa-solid fa-desktop"></i>Verwaltung/Zertifikate</a></li>
                            <!--li class="nav-item"><a href="{{ route('admin.student_course_dates.index') }}"
                                                    data-route="student_course_dates" class="nav-link"><i
                                        class="icn fa-solid fa-right-left"></i>Kursangebote</a></li-->
                            <!--li class="nav-item"><a href="{{ route('admin.student_course_changes.index') }}"
                                        data-route="student_course_changes" class="nav-link"><i
                                        class="icn fa-solid fa-right-left"></i>Kurswechsel</a></li-->
                            <li class="nav-item"><a href="{{ route('soon', 'Raumplanung') }}"
                                        data-route="Raumplanung" class="nav-link"><i
                                        class="icn fa-brands fa-buromobelexperte"></i>Raumplanung</a></li>
                            <li class="nav-item"><a href="{{ route('soon', 'Belehrung') }}"
                                        data-route="Belehrung" class="nav-link"><i
                                        class="icn fa-solid fa-person-chalkboard"></i>Belehrung</a></li>
                            <!--li class="nav-item"><a href="{{ route('soon', 'Kurseinstellung') }}"
                                                    data-route="Kurseinstellung" class="nav-link"><i
                                        class="icn fa-solid fa-gear"></i>Kurseinstellung</a></li-->
                        </ul>
                    </div>
                </li>
                @endadminCan

                @adminCan('read DozentenMenu')
                <li class="nav-item parent">
                    <div class="btn-toggle align-items-center rounded" data-bs-toggle="collapse"
                         data-bs-target="#dozenten-collapse" aria-expanded="true">
                        <i class="icn fa-solid fa-user-graduate"></i>Dozenten
                    </div>
                    <div class="collapse ms-2" id="dozenten-collapse">
                        <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                            <li class="nav-item"><a href="{{ route('admin.lecturers.index') }}"
                                data-route="lecturers" class="nav-link"><i
                                class="icn fa-solid fa-screwdriver-wrench"></i>Verwaltung</a></li>
                            <li class="nav-item"><a href="{{ route('soon', 'Beschwerden') }}"
                                data-route="Beschwerden" class="nav-link"><i
                                class="icn fa-solid fa-down-left-and-up-right-to-center"></i>Beschwerden</a>
                            </li>
                        </ul>
                    </div>
                </li>
                @endadminCan

                @adminCan('read CoachingMenu')
                <li class="nav-item parent">
                    <div class="btn-toggle align-items-center rounded" data-bs-toggle="collapse"
                         data-bs-target="#coaching-collapse" aria-expanded="true">
                        <i class="icn fa-solid fa-user-graduate"></i>Coaching
                    </div>
                    <div class="collapse ms-2" id="coaching-collapse">
                        <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                            <li class="nav-item"><a href="{{ route('admin.coaches.index') }}"
                                                    data-route="coaches" class="nav-link"><i
                                            class="icn fa-solid fa-screwdriver-wrench"></i>Coaches</a></li>
                            <li class="nav-item"><a href="{{ route('admin.coach_contracts.index') }}"
                                                    data-route="coach_contracts" class="nav-link"><i
                                            class="icn fa-solid fa-down-left-and-up-right-to-center"></i>Coach-Verträge</a>
                            </li>
                        </ul>
                    </div>
                </li>
                @endadminCan

                @adminCan('read AgenturMenu')
                <li class="nav-item parent">
                    <div class="btn-toggle align-items-center rounded" data-bs-toggle="collapse"
                         data-bs-target="#agentur-collapse" aria-expanded="true">
                        <i class="icn fa-solid fa-layer-group"></i>Agentur
                    </div>
                    <div class="collapse ms-2" id="agentur-collapse">
                        <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                            <li class="nav-item"><a
                                    href="{{ route('admin.job_centres.index') }}"
                                    data-route="job_centres" class="nav-link"><i
                                    class="icn fa-solid fa-building-ngo"></i>Jobcenter</a></li>
                            <li class="nav-item"><a
                                    href="{{ route('admin.employment_agencies.index') }}"
                                    data-route="employment_agencies" class="nav-link"><i
                                    class="icn fa-solid fa-building-ngo"></i>ArbeitAgenturen</a></li>
                            <li class="nav-item"><a href="{{ route('admin.agency_approvals.index') }}"
                                    data-route="agency_approvals" class="nav-link"><i
                                    class="icn fa-solid fa-building-ngo"></i>AgenturMaßnamen</a></li>
                            <li class="nav-item"><a href="{{ route('soon', 'Teilnehmer') }}"
                                    data-route="Teilnehmer" class="nav-link"><i
                                    class="icn fa-solid fa-user-group"></i>Teilnehmer</a></li>
                        </ul>
                    </div>
                </li>
                @endadminCan

                @adminCan('read BüroOrganisationMenu')
                <li class="nav-item parent">
                    <div class="btn-toggle align-items-center rounded" data-bs-toggle="collapse"
                         data-bs-target="#büro-collapse" aria-expanded="true">
                        <i class="icn fa-solid fa-layer-group"></i>Büro-Organisation
                    </div>
                    <div class="collapse ms-2" id="büro-collapse">
                        <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                            <li class="nav-item"><a href="{{ route('soon', 'Hardware-Arten') }}"
                                        data-route="Hardware-Arten" class="nav-link"><i
                                        class="icn fa-solid fa-display"></i>Hardware-Arten</a></li>
                            <li class="nav-item"><a href="{{ route('soon', 'Hardware') }}"
                                        data-route="Hardware" class="nav-link"><i
                                        class="icn fa-solid fa-display"></i>Hardware</a></li>
                            <li class="nav-item"><a href="{{ route('soon', 'Porto') }}"
                                        data-route="Porto" class="nav-link"><i
                                        class="icn fa-solid fa-file-export"></i>Porto</a></li>
                        </ul>
                    </div>
                </li>
                @endadminCan

                @adminCan('read BuchhaltungMenu')
                <li class="nav-item parent">
                    <div class="btn-toggle align-items-center rounded" data-bs-toggle="collapse"
                         data-bs-target="#buchhaltung-collapse" aria-expanded="true">
                        <i class="icn fa-solid fa-calculator"></i>Buchhaltung
                    </div>
                    <div class="collapse ms-2" id="buchhaltung-collapse">
                        <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                            <li class="nav-item"><a href="{{ route('soon', 'Buchhaltung') }}"
                                    data-route="Buchhaltung" class="nav-link"><i
                                    class="icn fa-solid fa-calculator"></i>Buchhaltung</a></li>
                            <li class="nav-item"><a
                                    href="{{ route('admin.contracts.index') }}"
                                    data-route="contracts" class="nav-link"><i
                                    class="icn fa-solid fa-file-signature"></i>Dozentenverträge</a></li>
                        </ul>
                    </div>
                </li>
                @endadminCan

                @adminCan('read ZugriffsrechteMenu')
                <li class="nav-item parent">
                    <div class="btn-toggle align-items-center rounded" data-bs-toggle="collapse"
                         data-bs-target="#access-collapse" aria-expanded="true">
                        <i class="icn fa-solid fa-universal-access"></i>Zugriffsrechte
                    </div>
                    <div class="collapse ms-2" id="access-collapse">
                        <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                            <li class="nav-item"><a href="{{ route('admin.users.index') }}"
                                data-route="users"
                                class="nav-link"><i class="icn fa-solid fa-user-group"></i>Users</a>
                            </li>
                            <li class="nav-item"><a href="{{ route('admin.roles.index') }}"
                                data-route="roles"
                                class="nav-link"><i
                                class="icn fa-solid fa-circle-user"></i>Roles</a>
                            </li>
                            <li class="nav-item"><a href="{{ route('admin.permissions.index') }}"
                                data-route="permissions" class="nav-link"><i
                                class="icn fa-solid fa-fingerprint"></i>Permissions</a></li>
                        </ul>
                    </div>
                </li>
                @endadminCan

                @adminCan('read CompanySettingsMenu')
                <li class="nav-item parent">
                    <div class="btn-toggle align-items-center rounded" data-bs-toggle="collapse"
                         data-bs-target="#company-collapse" aria-expanded="true">
                        <i class="icn fa-solid fa-user-graduate"></i>Firmen Daten
                    </div>
                    <div class="collapse ms-2" id="company-collapse">
                        <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                            <li class="nav-item"><a href="{{ route('admin.company_directors.index') }}"
                                                    data-route="company_directors" class="nav-link"><i
                                            class="icn fa-solid fa-screwdriver-wrench"></i>Geschäftsführer</a></li>
                            <li class="nav-item"><a href="{{ route('admin.company_settings.index') }}"
                                                    data-route="company_settings" class="nav-link"><i
                                            class="icn fa-solid fa-down-left-and-up-right-to-center"></i>Einstellungen</a>
                            </li>
                        </ul>
                    </div>
                </li>
                @endadminCan

                @adminCan('read SettingsMenu')
                <li class="nav-item parent">
                    <div class="btn-toggle align-items-center rounded" data-bs-toggle="collapse"
                         data-bs-target="#settings-collapse" aria-expanded="true">
                        <i class="icn fa-solid fa-gear"></i>Einstellungen
                    </div>
                    <div class="collapse ms-2" id="settings-collapse">
                        <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                            <li class="nav-item"><a href="{{ route('admin.course_platforms.index') }}"
                                                    data-route="course_platforms" class="nav-link"><i
                                        class="icn fa-solid fa-user-group"></i>Kurs Platformen</a></li>
                            <li class="nav-item"><a href="{{ route('admin.activity_status.index') }}"
                                        data-route="activity_status" class="nav-link"><i
                                        class="icn fa-solid fa-user-group"></i>Teilnehmer Status</a></li>
                            <li class="nav-item"><a href="{{ route('admin.cancellation_types.index') }}"
                                        data-route="cancellation_types" class="nav-link"><i
                                        class="icn fa-solid fa-power-off"></i>Abbruch Gründe</a></li>
                            <li class="nav-item"><a href="{{ route('admin.course_booking_types.index') }}"
                                        data-route="course_booking_types" class="nav-link"><i
                                        class="icn fa-solid fa-book-open-reader"></i>Buchungs Modi</a></li>
                            <li class="nav-item"><a href="{{ route('admin.document_types.index') }}"
                                        data-route="document_types" class="nav-link"><i
                                        class="icn fa-solid fa-file-circle-question"></i>Dokument Typen</a></li>
                            <li class="nav-item"><a href="{{ route('admin.dunning_levels.index') }}"
                                        data-route="dunning_levels" class="nav-link"><i
                                        class="icn fa-solid  fa-skull-crossbones"></i>Mahnstufen</a></li>
                            <li class="nav-item"><a href="{{ route('admin.found_reasons.index') }}"
                                        data-route="found_reasons" class="nav-link"><i
                                        class="icn fa-solid fa-eye"></i>Wie-Gefunden-Arten</a></li>
                            <li class="nav-item"><a href="{{ route('admin.hardware_types.index') }}"
                                        data-route="hardware_types" class="nav-link"><i
                                        class="icn fa-solid fa-computer"></i>Hardware Arten</a></li>
                            <li class="nav-item"><a href="{{ route('admin.participation_status.index') }}"
                                        data-route="participation_status" class="nav-link"><i
                                        class="icn fa-solid fa-person-chalkboard"></i>Anwesenheits Modi</a></li>
                            <li class="nav-item"><a href="{{ route('admin.progress_status.index') }}"
                                        data-route="progress_status" class="nav-link"><i
                                        class="icn fa-solid fa-list-check"></i>Progress Modi</a></li>
                            <li class="nav-item"><a href="{{ route('admin.course_change_reasons.index') }}"
                                                    data-route="course_change_reasons" class="nav-link"><i
                                        class="icn fa-solid fa-right-left"></i>Kurswechsel Gründe</a></li>
                            <li class="nav-item"><a href="{{ route('admin.salutations.index') }}"
                                        data-route="salutations" class="nav-link"><i
                                        class="icn fa-solid fa-hand-spock"></i>Anreden</a></li>
                            <li class="nav-item"><a href="{{ route('admin.student_content_types.index') }}"
                                        data-route="student_content_types" class="nav-link"><i
                                        class="icn fa-solid fa-file-circle-question"></i>Teilnehmer-Dokumente Arten</a></li>
                            <li class="nav-item"><a href="{{ route('admin.configHolidays.index') }}"
                                                    data-route="configHolidays" class="nav-link"><i
                                            class="icn fa-solid fa-calendar-days"></i>Feiertags-Arten</a></li>
                            <li class="nav-item"><a href="{{ route('admin.holidays.index') }}"
                                data-route="holidays" class="nav-link"><i
                                class="icn fa-solid fa-calendar-days"></i>Feiertage</a></li>
                        </ul>
                    </div>
                </li>
                @endadminCan

                @adminCan('read InfoMenu')
                <li class="nav-item parent">
                    <div class="btn-toggle align-items-center rounded" data-bs-toggle="collapse"
                         data-bs-target="#info-collapse" aria-expanded="true">
                        <i class="icn fa-solid fa-circle-info"></i>Informationen
                    </div>
                    <div class="collapse ms-2" id="info-collapse">
                        <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                            <li class="nav-item"><a href="{{ route('admin.infos.phpinfo') }}"
                                data-route="phpinfo"
                                class="nav-link"><i class="icn fa-brands fa-php"></i>PHP</a>
                            </li>
                            <li class="nav-item"><a href="{{ route('admin.infos.routes') }}"
                                data-route="routes"
                                class="nav-link"><i class="icn fa-solid fa-route"></i>Routen</a>
                            </li>
                        </ul>
                    </div>
                </li>
                @endadminCan

            </ul>
        </div>
    </div>
</div>

@push('inline-scripts')
    <script>
        const currentRouteBase = "{{ Request::segment(2) }}";
        Navbar.init(currentRouteBase);
    </script>
@endpush
