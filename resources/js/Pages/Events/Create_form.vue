<script setup>
import { useForm } from '@inertiajs/vue3';

const form = useForm({
    title: '',
    description: '',
    starts_at: '',
    ends_at: '',
    is_online: false,
    online_url: '',
    capacity: '',
    price_cents: 0,
    image_path: '',
});

</script>


<template>
    <div class="container d-flex justify-content-center">
        <div class="card w-50 shadow-sm">
            <div class="card-body">
                <h2 class="card-title mb-4 text-center">Create Event</h2>

                <!-- Display Form Errors -->
                <div v-if="Object.keys(form.errors).length > 0" class="alert alert-danger">
                    <ul class="mb-0">
                        <li v-for="(error, field) in form.errors" :key="field">{{ error }}</li>
                    </ul>
                </div>

                <!-- Form -->
                <form @submit.prevent="form.post(route('events.store'))">
                    <div class="mb-3">
                        <label for="title" class="form-label">Title</label>
                        <input v-model="form.title" type="text" name="title" class="form-control" maxlength="100" required/>
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea v-model="form.description" type="textarea" name="description" class="form-control" maxlength="1000" rows="3"></textarea>
                    </div>

                    <div class="row mb-3">
                        <div class="col">
                            <label for="starts_at" class="form-label">Starts at</label>
                            <input v-model="form.starts_at" type="datetime-local" name="starts_at" class="form-control" required/>
                        </div>
                        <div class="col">
                            <label for="ends_at" class="form-label">Ends at</label>
                            <input v-model="form.ends_at" type="datetime-local" name="ends_at" class="form-control"/>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label>Online Venue</label>
                        <input type="hidden" name="is_online" value="0"/>
                        <input type="checkbox" v-model="form.is_online" value="1"/>
                    </div>
                    <div class="row mb-3">
                        <div class="col">
                            <label for="location" class="form-label">Location</label>
                            <input v-model="form.location" type="text" name="location" class="form-control" maxlength="255"/>
                        </div>
                        <div class="col">
                            <label for="online_url" class="form-label">Online URL (if applicable)</label>
                            <input v-model="form.online_url" type="text" name="online_url" class="form-control" maxlength="255"/>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col">
                            <label for="capacity" class="form-label">Capacity (1~1000)</label>
                            <input v-model="form.capacity" type="number" name="capacity" class="form-control" min="1" max="1000" required/>
                        </div>
                        <div class="col">
                            <label for="price_cents" class="form-label">Price (cents)</label>
                            <input v-model="form.price_cents" type="number" name="price_cents" class="form-control" min="0"/>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="image_path" class="form-label">Event Image (if applicable)</label>
                        <input v-model="form.image_path" type="text" name="image_path" class="form-control" maxlength="2048"/>
                    </div>

                    <!-- Submit button -->
                    <div class="mt-3 text-center">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</template>
