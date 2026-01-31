<script setup>
import { Link } from '@inertiajs/vue3'

defineProps({
    event: Object,
})
</script>

<template>
    <div class="container py-4">
        <Link :href="route('events.index')" class="btn btn-link px-0 mb-3">
            &larr; Back to Events List
        </Link>

        <div class="card">
            <img v-if="event.image_path" :src="`/${event.image_path}`" :alt="event.title" class="event-detail-img" />

            <div class="card-body">
                <h3>{{ event.title }}</h3>

                <div class="row g-3">
                    <!-- Event details -->
                    <div class="col-md-6">
                        <div class="mb-2">
                            <strong>When:</strong>
                            {{ event.starts_at_formatted }}
                            <span v-if="event.ends_at_formatted"> - {{ event.ends_at_formatted }}</span>
                        </div>

                        <div class="mb-2">
                            <strong>Where:</strong>
                            {{ event.location }}
                            <span v-if="event.online_url">
                                (<a :href="event.online_url" target="_blank" rel="noopener">Join Link</a>)
                            </span>
                        </div>

                        <div class="mb-2">
                            <strong>Capacity:</strong> {{ event.capacity }}
                        </div>

                        <div class="mb-2">
                            <strong>Organiser:</strong> {{ event.organiser?.name }}
                        </div>

                        <div class="d-flex gap-2 justify-content-end mb-3">
                            <Link :href="route('events.edit', event)" class="btn btn-sm btn-primary"> Edit </Link>
                        </div>

                    </div>
                </div>
            </div>

            <template v-if="event.description">
                <hr />
                <div class="mt-2 px-4">
                    <strong>Event Description:</strong><br />
                    <p class="ms-4">{{ event.description }}</p>
                </div>
            </template>
        </div>
    </div>
</template>
