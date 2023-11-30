<script setup>
import { onMounted, ref } from 'vue';

defineProps({
    modelValue: {
        type: String,
        required: true,
    },
});

const showPassword = ref(false);

defineEmits(['update:modelValue']);

const input = ref(null);

onMounted(() => {
    if (input.value.hasAttribute('autofocus')) {
        input.value.focus();
    }
});

defineExpose({ focus: () => input.value.focus() });
</script>

<template>
    <input
        class="form-control"
        :type="showPassword ? 'text' : 'password'"
        :value="modelValue"
        @input="$emit('update:modelValue', $event.target.value)"
        ref="input"
    />
    <span class="input-group-text" @click="showPassword = !showPassword" style="font-size: 24px;">
        <ion-icon name="eye" v-if="!showPassword"></ion-icon>
        <ion-icon name="eye-off" v-if="showPassword"></ion-icon>
    </span>

    <!-- <input
    :type="showPassword ? 'text' : 'password'"
    class="form-control" autocomplete="off"
    :class="{ 'is-invalid': form.errors.password }" placeholder="Your password" v-model="form.password">
    <span class="input-group-text" @click="showPassword = !showPassword" style="font-size: 24px;">
        <ion-icon name="eye" v-if="!showPassword"></ion-icon>
        <ion-icon name="eye-off" v-if="showPassword"></ion-icon>
    </span> -->
</template>
