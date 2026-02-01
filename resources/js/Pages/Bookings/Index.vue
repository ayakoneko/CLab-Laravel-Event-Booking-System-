<script setup>
import { usePage } from '@inertiajs/vue3';
import { Link } from '@inertiajs/vue3'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'

defineProps({
    bookings: Object,
})

const { errors } = usePage()

defineOptions({
    layout: AuthenticatedLayout,
})
</script>

<template>
    <div>
        <!-- Page Heading -->
        <header class="bg-white shadow">
            <div class="container py-6 px-4 sm:px-6 lg:px-8">
                <h1 class="h2 mb-0">Upcoming Events</h1>
            </div>
        </header>

        <!-- Error Message -->
        <div v-if="Object.keys(errors).length > 0" class="alert alert-danger">
            <ul>
                <li v-for="(message, field) in errors" :key="field">{{ message[0] }}</li>
            </ul>
        </div>

        <!-- Page Content -->
        <main class="container py-4">
            <!-- Event List -->
            <div v-if="bookings.length" class="row g-3">
                <div v-for="booking in bookings" :key="booking.id" class="col-12 col-sm-6 col-lg-3">
                    <div class="card h-100 position-relative">
                        <div class="card-body d-flex flex-column">
                            <Link :href="route('events.show', { event: booking.event.id })" class="card-title mb-2" :title="booking.event.title">{{ booking.event.title }}</Link>
                            <div class="small text-muted">
                                <div>{{ booking.event.starts_at_formatted }}</div>
                                <div>Ticket: {{ booking.ticket_code }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Empty State -->
            <p v-else class="text-muted text-center py-5">No Confirmed Bookings</p>

        </main>
    </div>
</template>

