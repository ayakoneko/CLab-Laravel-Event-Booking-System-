<script setup>
import { Link } from '@inertiajs/vue3'

defineProps({
    event: Object,
})
</script>

<template>
    <div class="max-w-3xl mx-auto p-6">
        <Link :href="route('events.index')" class="text-blue-600 text-sm underline">
            Back to Events List
        </Link>

        <div class="mt-4 border rounded p-4">
            <img v-if="event.image_path" :src="event.image_path" alt="" class="w-full rounded mb-4" />

            <h1 class="text-2xl font-bold">
                {{ event.title }}
            </h1>

            <p class="text-sm text-gray-600 mt-2">
                {{ event.starts_at }}
            </p>
        </div>
    </div>
</template>
