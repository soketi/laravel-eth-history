<template>
    <div>
        <div class="min-h-screen bg-gray-100">
            <!-- Page Heading -->
            <header
                v-if="$slots.header"
                class="bg-white shadow"
            >
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    <slot name="header" />
                </div>
            </header>

            <!-- Page Content -->
            <main>
                <slot />
            </main>
        </div>
    </div>
</template>

<script>
import { Link } from '@inertiajs/inertia-vue3';

export default {
    components: {
        Link,
    },

    data() {
        return {
            showingNavigationDropdown: false,
        }
    },
}
</script>
