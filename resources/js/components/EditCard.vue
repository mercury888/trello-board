<template>
  <vue-final-modal :click-to-close="false" v-slot="{ close }" v-bind="$attrs" classes="modal-container" content-class="modal-content">
    <span class="modal__title">Update Card</span>
    <div class="modal__content">
	  <label>Title</label>
      <input v-model="data.title">
	  
	  <label>Description</label>
      <textarea v-model="data.description" />
    </div>
	<div class="modal__action">
		<button type="button" @click="$emit('confirm', data, close)" >Save</button>
		<button type="button" @click="$emit('cancel', close)" >cancel</button>
    </div>
  </vue-final-modal>
</template>
<script>
export default {
	name:"AddCard",
	inheritAttrs: false,
	emits: ['confirm', 'cancel'],
	props: {
		cardid: {
		  type: Number,
		  default: ''
		},
		cardname: {
		  type: String,
		  default: ''
		},
		carddescription: {
		  type: String,
		  default: ''
		}
	  },
	data(){
        return {
            data:{
				id: this.cardid,
				title: this.cardname,
				description: this.carddescription,
			},
        }
    },
}
</script>
<style scoped>
::v-deep(.modal-container) {
  display: flex;
  justify-content: center;
  align-items: center;
}
::v-deep(.modal-content) {
  position: relative;
  display: flex;
  flex-direction: column;
  margin: 0 1rem;
  padding: 1rem;
  border: 1px solid #e2e8f0;
  border-radius: 0.25rem;
  background: #fff;
}
.modal__title {
  margin: 0 2rem 0 0;
  font-size: 1.5rem;
  font-weight: 700;
}
.modal__close {
  position: absolute;
  top: 0.5rem;
  right: 0.5rem;
}
</style>

<style scoped>
.dark-mode div::v-deep(.modal-content) {
  border-color: #2d3748;
  background-color: #1a202c;
}
</style>