<script setup>
import { onMounted, ref } from 'vue';
import accounting from 'accounting';

const props = defineProps({
  modelValue: {
    type: Number,
    required: true,
  },
});

const emit = defineEmits(['update:modelValue']);

const input = ref(null);

onMounted(() => {
  if (input.value.hasAttribute('autofocus')) {
    input.value.focus();
  }

  if (!props.modelValue) {
    emit('update:modelValue', 0);
  }
});

const formatCurrency = (value) => {
    const decimalCount = (value.toString().split('.')[1] || '').length;
    return accounting.formatMoney(value, {
        symbol: '',   // Tidak menampilkan simbol mata uang
        precision: decimalCount,  // Menampilkan 2 angka di belakang koma
        thousand: ',', // Menyusun ribuan dengan titik
        decimal: '.',  // Menyusun desimal dengan koma
    });
};

const parseCurrency = (formattedValue) => {
  return accounting.unformat(formattedValue);
};

const handleInput = (event) => {
  let inputValue = event.target.value;
  const previousValue = props.modelValue;
  inputValue = inputValue.replace(/\,/g, '');
  if (inputValue === '') {
    inputValue = '0';
  }
//   const isNumeric = /^\d+$/.test(inputValue); bilangan integer saja tanpa decimal
  const isNumeric = /^\d*(\.\d{0,2})?$/.test(inputValue); // bilangan decimal 2 digit saja setelah titik
  if (isNumeric) {
    console.log('valid input: ' + inputValue);
    const numericValue = parseCurrency(inputValue);
    if (inputValue.endsWith('.')) {
        console.log('Input ends with a dot');
        event.target.value = formatCurrency(numericValue) + '.';
    }
    else {
        event.target.value = formatCurrency(numericValue);
    }

    emit('update:modelValue', numericValue);

  } else {
    console.log('tidak valid input: ' + inputValue);
    event.target.value = formatCurrency(previousValue);
  }
};

defineExpose({ focus: () => input.value.focus() });
</script>

<template>
  <input
    type="text"
    :value="formatCurrency(modelValue)"
    @input="handleInput"
    ref="input"
  />
</template>
