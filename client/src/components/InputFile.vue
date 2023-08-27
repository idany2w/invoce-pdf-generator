<template>
  <label class="input-file">
    <input
      class="input-file__input"
      type="file"
      :name="name"
			:multiple="multiple"
      @change="inputFileChage"
    />
  </label>
</template>

<script>
export default {
	name: 'InputFile',
	props:{
		files:{
			default: []
		},
		name: String,
		multiple: {
			type: Boolean,
			default: false
		},
	},
	emits:[
		'update:files'
	],
	methods: {
		inputFileChage(e){
			this.$emit('update:files', e.target.files)
		}
	},
};
</script>

<style>
</style>