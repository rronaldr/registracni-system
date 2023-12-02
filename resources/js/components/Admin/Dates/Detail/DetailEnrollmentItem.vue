<template>
    <tr>
        <td>{{ enrollment.xname }}</td>
        <td>{{ enrollment.email }}</td>
        <td>{{ enrollment.enrolled }}</td>
        <td>{{ enrollment.name }}</td>
        <td>
            <button
                type="button"
                :title="$t('enrollment.show_fields')"
                class="btn-link text-primary border-0 mr-1"
                @click="showCustomFields = !showCustomFields"
            >
                <i class="fas fa-tags"></i>
            </button>
        </td>
    </tr>
    <div v-if="showCustomFields" class="font-weight-bold">
        {{ enrollment.custom_fields }}
    </div>
</template>

<script setup>
import { ref } from 'vue'

defineProps({
    enrollment: { type: Object, required: true }
})
let showCustomFields = ref(false)
</script>
