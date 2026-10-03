<?php

require_once "../../helpers/auth_check.php";
require_once "../../controllers/AdminController.php";

checkLogin();
checkRole(1);

$adminController = new AdminController();

$data = $adminController->dashboard();

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Admin Dashboard - ScholarX</title>

    <link
        rel="stylesheet"
        href="/ScholarX/assets/css/style.css"
    >

</head>


<body class="sx-dashboard">


    <!-- =========================================================
         DASHBOARD HEADER
         ========================================================= -->

    <section class="sx-dashboard-hero">

        <div class="sx-hero-content">

            <div class="sx-eyebrow">
                ADMINISTRATOR WORKSPACE
            </div>

            <h1>
                Welcome back,
                <?= htmlspecialchars($_SESSION['name']); ?>
            </h1>

            <p>
                Manage users, research opportunities and system
                activities from your ScholarX workspace.
            </p>

        </div>


        <div class="sx-hero-decoration">

            <div class="sx-orb sx-orb-one"></div>

            <div class="sx-orb sx-orb-two"></div>

            <div class="sx-grid-pattern"></div>

        </div>

    </section>



    <!-- =========================================================
         STATISTICS
         ========================================================= -->

    <section class="sx-section">

        <div class="sx-section-heading">

            <div>

                <span class="sx-section-label">
                    OVERVIEW
                </span>

                <h2>
                    System Overview
                </h2>

            </div>

            <span class="sx-section-description">
                Current ScholarX user distribution
            </span>

        </div>



        <div class="sx-stat-grid">


            <!-- Total Users -->

            <article class="sx-stat-card sx-stat-primary">

                <div class="sx-stat-top">

                    <div class="sx-stat-icon">

                        <svg
                            viewBox="0 0 24 24"
                            aria-hidden="true"
                        >
                            <path
                                d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"
                            />

                            <circle
                                cx="9"
                                cy="7"
                                r="4"
                            />

                            <path
                                d="M22 21v-2a4 4 0 0 0-3-3.87"
                            />

                            <path
                                d="M16 3.13a4 4 0 0 1 0 7.75"
                            />

                        </svg>

                    </div>

                    <span class="sx-stat-tag">
                        USERS
                    </span>

                </div>


                <div class="sx-stat-number">

                    <?= htmlspecialchars($data['totalUsers']); ?>

                </div>


                <div class="sx-stat-title">
                    Total Users
                </div>


                <div class="sx-stat-line"></div>

            </article>



            <!-- Students -->

            <article class="sx-stat-card sx-stat-blue">

                <div class="sx-stat-top">

                    <div class="sx-stat-icon">

                        <svg
                            viewBox="0 0 24 24"
                            aria-hidden="true"
                        >

                            <path
                                d="M22 10L12 5 2 10l10 5 10-5Z"
                            />

                            <path
                                d="M6 12v5c3 2 9 2 12 0v-5"
                            />

                            <path
                                d="M22 10v6"
                            />

                        </svg>

                    </div>

                    <span class="sx-stat-tag">
                        STUDENTS
                    </span>

                </div>


                <div class="sx-stat-number">

                    <?= htmlspecialchars($data['totalStudents']); ?>

                </div>


                <div class="sx-stat-title">
                    Registered Students
                </div>


                <div class="sx-stat-line"></div>

            </article>



            <!-- Supervisors -->

            <article class="sx-stat-card sx-stat-purple">

                <div class="sx-stat-top">

                    <div class="sx-stat-icon">

                        <svg
                            viewBox="0 0 24 24"
                            aria-hidden="true"
                        >

                            <circle
                                cx="12"
                                cy="8"
                                r="4"
                            />

                            <path
                                d="M5 21a7 7 0 0 1 14 0"
                            />

                        </svg>

                    </div>

                    <span class="sx-stat-tag">
                        SUPERVISORS
                    </span>

                </div>


                <div class="sx-stat-number">

                    <?= htmlspecialchars($data['totalSupervisors']); ?>

                </div>


                <div class="sx-stat-title">
                    Research Supervisors
                </div>


                <div class="sx-stat-line"></div>

            </article>



            <!-- Coordinators -->

            <article class="sx-stat-card sx-stat-green">

                <div class="sx-stat-top">

                    <div class="sx-stat-icon">

                        <svg
                            viewBox="0 0 24 24"
                            aria-hidden="true"
                        >

                            <path
                                d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"
                            />

                            <circle
                                cx="9"
                                cy="7"
                                r="4"
                            />

                            <path
                                d="M19 8v6"
                            />

                            <path
                                d="M22 11h-6"
                            />

                        </svg>

                    </div>

                    <span class="sx-stat-tag">
                        COORDINATORS
                    </span>

                </div>


                <div class="sx-stat-number">

                    <?= htmlspecialchars($data['totalCoordinators']); ?>

                </div>


                <div class="sx-stat-title">
                    Research Coordinators
                </div>


                <div class="sx-stat-line"></div>

            </article>


        </div>

    </section>



    <!-- =========================================================
         QUICK ACTIONS
         ========================================================= -->

    <section class="sx-section sx-actions-section">

        <div class="sx-section-heading">

            <div>

                <span class="sx-section-label">
                    MANAGEMENT
                </span>

                <h2>
                    Quick Actions
                </h2>

            </div>

            <span class="sx-section-description">
                Access frequently used administrator tools
            </span>

        </div>



        <div class="sx-action-grid">


            <!-- Users -->

            <a
                href="users.php"
                class="sx-action-card"
            >

                <div class="sx-action-icon sx-icon-blue">

                    <svg
                        viewBox="0 0 24 24"
                        aria-hidden="true"
                    >

                        <path
                            d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"
                        />

                        <circle
                            cx="9"
                            cy="7"
                            r="4"
                        />

                        <path
                            d="M22 21v-2a4 4 0 0 0-3-3.87"
                        />

                        <path
                            d="M16 3.13a4 4 0 0 1 0 7.75"
                        />

                    </svg>

                </div>


                <div class="sx-action-content">

                    <h3>
                        Manage Users
                    </h3>

                    <p>
                        View, search, activate and manage
                        registered ScholarX users.
                    </p>

                </div>


                <span class="sx-action-arrow">
                    →
                </span>

            </a>



            <!-- Activities -->

            <a
                href="activities.php"
                class="sx-action-card"
            >

                <div class="sx-action-icon sx-icon-purple">

                    <svg
                        viewBox="0 0 24 24"
                        aria-hidden="true"
                    >

                        <polyline
                            points="3 12 7 12 10 4 14 20 17 12 21 12"
                        />

                    </svg>

                </div>


                <div class="sx-action-content">

                    <h3>
                        Monitor Activities
                    </h3>

                    <p>
                        Review login events and important
                        system activity logs.
                    </p>

                </div>


                <span class="sx-action-arrow">
                    →
                </span>

            </a>



            <!-- Research -->

            <a
                href="research.php"
                class="sx-action-card"
            >

                <div class="sx-action-icon sx-icon-green">

                    <svg
                        viewBox="0 0 24 24"
                        aria-hidden="true"
                    >

                        <path
                            d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"
                        />

                        <path
                            d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2Z"
                        />

                    </svg>

                </div>


                <div class="sx-action-content">

                    <h3>
                        Research Opportunities
                    </h3>

                    <p>
                        Review and manage research opportunities
                        across the university.
                    </p>

                </div>


                <span class="sx-action-arrow">
                    →
                </span>

            </a>



            <!-- Announcements -->

            <a
                href="announcements.php"
                class="sx-action-card"
            >

                <div class="sx-action-icon sx-icon-orange">

                    <svg
                        viewBox="0 0 24 24"
                        aria-hidden="true"
                    >

                        <path
                            d="M18 8a6 6 0 0 0-12 0c0 7-3 7-3 9h18c0-2-3-2-3-9"
                        />

                        <path
                            d="M13.73 21a2 2 0 0 1-3.46 0"
                        />

                    </svg>

                </div>


                <div class="sx-action-content">

                    <h3>
                        Announcements
                    </h3>

                    <p>
                        Publish and manage announcements
                        for the ScholarX community.
                    </p>

                </div>


                <span class="sx-action-arrow">
                    →
                </span>

            </a>


        </div>

    </section>



    <!-- =========================================================
         ADMINISTRATOR FOOTER PANEL
         ========================================================= -->

    <section class="sx-admin-footer-card">

        <div class="sx-footer-icon">

            <span>✦</span>

        </div>


        <div>

            <span class="sx-section-label">
                SCHOLARX ADMINISTRATION
            </span>

            <h3>
                Your administrative workspace
            </h3>

            <p>
                Use the navigation panel or quick actions above
                to manage the ScholarX research ecosystem.
            </p>

        </div>

    </section>



    <!-- =========================================================
         LOGOUT
         ========================================================= -->

    <a
        href="../auth/logout.php"
        class="sx-logout-link"
    >
        Logout
    </a>



    <script src="/ScholarX/assets/js/app.js"></script>

</body>

</html>