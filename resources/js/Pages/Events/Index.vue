<script setup>
import { Link } from '@inertiajs/vue3'

defineProps({
    events: Object,
})
</script>

<template>
    <div class="max-w-4xl mx-auto p-6">
        <h1 class="text-2xl font-bold mb-4">Upcoming Events</h1>

        <!-- Event List -->
        <div v-if="events.data.length" class="space-y-4">
            <div v-for="event in events.data" :key="event.id" class="border rounded p-4">
                <h2 class="text-lg font-semibold">{{ event.title }}</h2>
                <p class="text-sm text-gray-600">{{ new Date(event.starts_at).toLocaleString() }}</p>
                <Link :href="`/events/${event.id}`" class="text-blue-600 text-sm underline mt-2 inline-block">View Details</Link>


            </div>
        </div>

        <!-- Empty State -->
        <p v-else class="text-gray-500">No Upcoming events</p>

        <!-- Pagination -->


    </div>


</template>

