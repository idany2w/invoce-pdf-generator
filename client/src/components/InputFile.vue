<template>
  <label class="input-file">
    <input
      class="input-file__input"
      type="file"
      :name="name"
			:multiple="multiple"
      @change="inputFileChage"
			ref="input"
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
			if(this.multiple){
				this.$emit('update:files', e.target.files)
			} else {
				this.$emit('update:files', e.target.files[0])
			}
		}
	},
	watch:{
		files(value){
			if(!value){
				this.$refs.input.value = null;
			}
		}
	}
};
</script>

<style>
</style>