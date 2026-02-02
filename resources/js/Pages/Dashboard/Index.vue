<script setup>
import { usePage } from '@inertiajs/vue3';
import { Link } from '@inertiajs/vue3'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'

const { reports, user } = usePage().props;

defineOptions({
    layout: AuthenticatedLayout,
})

import { Inertia } from '@inertiajs/inertia';

Inertia.on('navigate', (event) => {
    console.log(event); // Will log the navigation event details, including potential errors
});

</script>

<template>
    <div>
        <header class="bg-white shadow">
            <div class="container py-6 px-4 sm:px-6 lg:px-8">
                <h1 class="h2 mb-0">Organiser Dashboard - ({{ compileToFunction($report) }}) events</h1>
            </div>
        </header>

        <main class="container py-4">
            <!-- Event List -->
            <div v-if="reports.length" class="row g-3">
                <div v-for="report in reports" :key="report.id" class="col-12 col-sm-6 col-lg-3">
                    <table class="table table-striped mt-3">
                        <thead>
                            <tr>
                                <th>Event Title</th>
                                <th>Date (Start at) </th>
                                <th>Capacity</th>
                                <th>Bookings</th>
                                <th>Remaining</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="booking in bookings" :key="booking.id">
                                <td><Link :href="route('events.show', { event: booking.event.id })" class="card-title mb-2" :title="booking.event.title">{{ booking.event.title }}</Link></td>
                                <td>{{ booking.event.starts_at_formatted}}</td>
                                <td>{{ booking.event.capacity }}</td>
                                <td>{{ booking.event.hasconfirmed().count() }}</td>
                                <td>{{ booking.event.hasremaining().count() }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Empty State -->
            <p v-else class="text-muted text-center py-5">No events found.</p>

        </main>
    </div>
</template>

