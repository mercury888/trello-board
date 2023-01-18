<template>
	<div class="cards-list">
		<draggable class="list-group" :list="cards.data" group="people" item-key="{ columnId }" @change="log">
			<template #item="{ element }">
				<div class="cards">
					<a class="list-group-item" ref="javascript:void(0);" @click="openeditmodal(element.id,element.name,element.description)">{{ element.name  }}</a>
				</div>
			</template>	
		</draggable>
	</div >
	<a @click="openmodal(columnId)" class="add-card" href="javascript:void(0);">
		<span>Add Card</span>
	</a>
</template>
<script>
import AddCard from "./AddCard.vue";
import EditCard from "./EditCard.vue";
import draggable from "vuedraggable";
import $api from './../api.js';
export default {
	name:"Cards",
	components: {
		AddCard,
		EditCard,
		draggable
	},
	props: {
		columnId: Number,
	},
    data(){
        return {
			clickHandler: {
                type: Function,
                default() {
                    return function () {};
                }
            },
            cards:{},
        }
    },
    mounted(){
        this.getCards(this.columnId)
		
    },
    methods:{
        async getCards(columnId){
            await $api.get('/list-cards/'+columnId).then(response=>{
                this.cards = response.data
            }).catch(error=>{
                console.log(error)
                this.cards = {}
            })
        },
		openmodal(columnId){
			const _self = this;
			this.$vfm.show({ 
				component: AddCard,
				on: {
				  confirm(data, close) {
					let newCard = {
						name: data.title,
						column_id: columnId
					}
					$api.post('/card/save', newCard).then(response=>{
						_self.getCards(columnId);
					}).catch(error=>{
						console.log(error)
					})
					close()
				  },
				  cancel(close) {
					console.log('cancel')
					close()
				  }
				}
			})
		},
		openeditmodal(cardId,name,description){
			const _self = this;
			this.$vfm.show({ 
				component: EditCard,
				bind: {
					name: 'edit-card',
					cardid: cardId,
					cardname: name,
					carddescription: description,
				},
				on: {
				  confirm(data, close) {
					let newCard = {
						name: data.title,
						description: data.description,
						id: data.id,
					}
					$api.post('/card/update', newCard).then(response=>{
						_self.getCards(_self.columnId);
					}).catch(error=>{
						console.log(error)
					})
					close()
				  },
				  cancel(close) {
					console.log('cancel')
					close()
				  }
				}
			})
		},
		log: function(e) {
			if(e.added){
				const column_id = this.columnId;
				this.cards.data.forEach(function(item, index){
				  item.orderindex = index+1;
				  item.column_id = column_id;
				  delete item.created_at;
				  delete item.updated_at;
				});
				$api.post('/card/updateall', this.cards).then(response=>{
					console.log("updated")
				}).catch(error=>{
					console.log(error)
				})
			}
			if(e.moved){
				const column_id = this.columnId;
				this.cards.data.forEach(function(item, index){
				  item.orderindex = index+1;
				  item.column_id = column_id;
				  delete item.created_at;
				  delete item.updated_at;
				});
				$api.post('/card/updateall', this.cards).then(response=>{
					console.log("updated")
				}).catch(error=>{
					console.log(error)
				})
				console.log(this.cards.data);
			}
		}
    }
}
</script>