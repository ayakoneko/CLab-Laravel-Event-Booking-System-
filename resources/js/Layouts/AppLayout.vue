<script setup>
import { Link, usePage } from '@inertiajs/vue3';
import { computed } from 'vue';

const page = usePage();

// Get flash messages from server
const flash = computed(() => page.props.flash);

// Get auth data
const auth = computed(() => page.props.auth);
const user = computed(() => auth.value?.user);

// Determine if user is organiser
const isOrganiser = computed(() => user.value?.type === 'organiser');
</script>

<template>
    <div class="min-h-screen bg-gray-100">
        <!-- Navigation Bar -->
        <nav class="navbar navbar-expand-lg bg-white border-bottom sticky-top">
            <div class="container">
                <Link :href="route('events.index')" class="navbar-brand">
                    <img
                        src="/images/logo.png"
                        alt="Logo"
                        width="30"
                        height="30"
                        class="me-2"
                    >
                    EventBooking
                </Link>

                <button
                    class="navbar-toggler"
                    type="button"
                    data-bs-toggle="collapse"
                    data-bs-target="#mainNav"
                    aria-controls="mainNav"
                    aria-expanded="false"
                    aria-label="Toggle navigation"
                >
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="mainNav">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <!-- Authenticated User Menu -->
                        <template v-if="user">
                            <!-- Organizer Menu -->
                            <template v-if="isOrganiser">
                                <li class="nav-item">
                                    <Link :href="route('events.create')" class="nav-link">
                                        Create Event
                                    </Link>
                                </li>
                                <!-- <li class="nav-item">
                                    <Link :href="route('organiser.dashboard')" class="nav-link">
                                        Event Dashboard
                                    </Link>
                                </li> -->
                            </template>

                            <!-- Attendee Menu -->
                            <!-- <template v-else>
                                <li class="nav-item">
                                    <Link :href="route('bookings.index')" class="nav-link">
                                        My Bookings
                                    </Link>
                                </li>
                                <li class="nav-item">
                                    <Link :href="route('waitlists.index')" class="nav-link">
                                        My Waitlists
                                    </Link>
                                </li>
                            </template> -->
                        </template>

                        <!-- Guest Menu -->
                        <template v-else>
                            <li class="nav-item">
                                <Link :href="route('events.create')" class="nav-link">
                                    Create Event
                                </Link>
                            </li>
                            <!-- <li class="nav-item">
                                <Link :href="route('bookings.index')" class="nav-link">
                                    My Bookings
                                </Link>
                            </li> -->
                        </template>
                    </ul>

                    <!-- Right side: Auth actions -->
                    <ul class="navbar-nav ms-auto">
                        <!-- Unauthenticated -->
                        <template v-if="!user">
                            <li class="nav-item">
                                <Link :href="route('login')" class="nav-link">
                                    Log in
                                </Link>
                            </li>
                            <li class="nav-item">
                                <Link :href="route('register')" class="nav-link">
                                    Register
                                </Link>
                            </li>
                        </template>

                        <!-- Authenticated -->
                        <template v-else>
                            <li class="nav-item dropdown">
                                <a
                                    class="nav-link dropdown-toggle"
                                    href="#"
                                    role="button"
                                    data-bs-toggle="dropdown"
                                    aria-expanded="false"
                                >
                                    {{ user.name }} ({{ user.type }})
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li>
                                        <Link :href="route('profile.edit')" class="dropdown-item">
                                            Profile
                                        </Link>
                                    </li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li>
                                        <Link
                                            :href="route('logout')"
                                            method="post"
                                            as="button"
                                            class="dropdown-item"
                                        >
                                            Log Out
                                        </Link>
                                    </li>
                                </ul>
                            </li>
                        </template>
                    </ul>
                </div>
            </div>
        </nav>

        <!-- Flash Messages -->
        <div class="container mt-3">
            <!-- Success Alert -->
            <div v-if="flash?.success" class="alert alert-success alert-dismissible fade show" role="alert">
                {{ flash.success }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>

            <!-- Error Alert -->
            <div v-if="flash?.error" class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ flash.error }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        </div>

        <!-- Page Content -->
        <slot />
    </div>
</template>
