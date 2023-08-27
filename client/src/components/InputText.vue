<template>
	<label class="form__input input-text">
		<span
			v-if="label"
			class="input-text__label"
			:class="labelClass"
		>
			{{ label }}
		</span>
		<input
			class="input-text__input"
			:type="type"
			:name="name"
			:placeholder="placeholder"
			:value="modelValue"
			@input="$emit('update:modelValue', $event.target.value)"
		/>
	</label>
</template>

<script>
export default {
	name:'InputText',
	props:{
    modelValue: String,
		label: {
			default: null
		},
		labelClass: {
			default: null
		},
		name: {
			default: null
		},
		placeholder: {
			default: null
		},
		type: {
			default: 'text'
		},
	}
}
</script>

<style lang="scss">
.input-text {
  display: block;

  &__input {
    display: flex;
    width: 100%;
    border-color: var(--color-4);
    border-width: 1px;
    border-style: solid;
    padding: 8px;
    outline: none;
    box-shadow: none;
  }
}
</style>