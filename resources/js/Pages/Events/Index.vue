<script setup>
import { Link } from '@inertiajs/vue3'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'

defineProps({
    events: Object,
})

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

        <!-- Page Content -->
        <main class="container py-4">
            <!-- Event List -->
            <div v-if="events.data.length" class="row g-3">
            <div v-for="event in events.data" :key="event.id" class="col-12 col-sm-6 col-lg-3">
                <div class="card h-100 position-relative">
                    <img v-if="event.image_path" :src="`/${event.image_path}`" :alt="event.title" class="card-img-top event-list-img" />


                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title mb-2" :title="event.title">{{ event.title }}</h5>
                        <div class="small text-muted">
                            <div>{{ event.starts_at_formatted }}</div>
                            <div>{{ event.location }}</div>
                        </div>

                        <Link :href="`/events/${event.id}`" class="stretched-link mt-auto">Details</Link>
                    </div>
                </div>
            </div>
        </div>

            <!-- Empty State -->
            <p v-else class="text-muted text-center py-5">No upcoming events</p>

            <!-- Pagination -->
            <nav aria-label="Page navigation" class="mt-4">
                <ul class="pagination justify-content-center">
                    <li v-for="link in events.links" :key="link.label" class="page-item" :class="{'active': link.active, 'disabled': !link.url}">
                        <Link :href="link.url ?? '#'" class="page-link" v-html="link.label"/>
                    </li>
                </ul>
            </nav>
        </main>
    </div>
</template>

