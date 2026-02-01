<script setup>
import { Link } from '@inertiajs/vue3';
import { Inertia } from '@inertiajs/inertia';
import { useForm } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'

const props = defineProps({
    event: Object,
})

defineOptions({
    layout: AuthenticatedLayout,
})

const form = useForm({
    title: props.event.title,
    description: props.event.description,
    starts_at: props.event.starts_at,
    ends_at: props.event.ends_at,
    is_online: props.event.is_online,
    location: props.event.location,
    online_url: props.event.online_url,
    capacity: props.event.capacity,
    price_cents: props.event.price_cents,
    image_path: props.event.image_path,
});


const handleDelete = () => {
    if (confirm('Are you sure you want to delete this event? This cannot be undone.')) {
        Inertia.delete(route('events.destroy', props.event));
    }
};

</script>

<template>
    <div class="min-h-screen bg-gray-100">
        <!-- Page Heading -->
        <header class="bg-white shadow">
            <div class="container py-6 px-4 sm:px-6 lg:px-8">
                <Link :href="route('events.index')" class="btn btn-link px-0 mb-0">
                    &larr; Back to Events
                </Link>
            </div>
        </header>

        <!-- Page Content -->
        <main class="container py-4">
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

                        <div v-if="$page.props.auth.user.type === 'organiser' && $page.props.auth.user.id === props.event.organiser_id" class="d-flex gap-2 justify-content-end mb-3">
                            <Link :href="route('events.edit', event)" class="btn btn-sm btn-primary"> Edit </Link>
                            <button @click="handleDelete" type="button" class="btn btn-sm btn-outline-danger"> Delete </button>
                        </div>

                    </div>
                </div>
            </div>

                <template v-if="event.description && event.description.length">
                    <hr />
                    <div class="mt-2 px-4">
                        <strong>Event Description:</strong><br />
                        <p class="ms-4">{{ event.description }}</p>
                    </div>
                </template>
            </div>
        </main>
    </div>
</template>
