<script setup>
import { Link } from '@inertiajs/vue3'

defineProps({
    events: Object,
})
</script>

<template>
    <div class="container py-4">
        <div class="d-flex align-item-center justify-content-between mb-3">
            <h1 class="h4 mb-0">Upcoming Events</h1>
        </div>

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
        <p v-else class="text-gray-500">No Upcoming events</p>

        <!-- Pagination -->
        <div>
            <Link v-for="link in events.links" :key="link.label" :href="link.url ?? ''" v-html="link.label"
                class="btn btn-sm" :class="{'btn-primary': link.active, 'btn-outline-secondary': !link.active, 'disabled': !link.url}"/>
        </div>
    </div>
</template>

