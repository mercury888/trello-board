<template>
    <h1>{{ title }}</h1>
	<div class="column-box">
		<div class="column-list" v-if="columns && (columns.data || []).length > 0">
			<div class="columns" v-for="(column,key) in columns.data" :key="key">
				<p class="column-name">{{ column.name  }} <span class="delete_x" @click="delete_column(column.id)">X</span></p>
				<cards :column-id="column.id" />
			</div>
		</div>
		<a class="add-column" @click="openmodal" href="javascript:void(0);">
			<span>Add Column</span>
		</a>
	</div>
	<div class="bottom-right">
		<a class="export" @click="exportdb" href="javascript:void(0);">
			<span>EXPORT DB</span>
		</a>
	</div>
	<modals-container ref="vuemodal"></modals-container>
</template>
<script>
import { ModalsContainer } from 'vue-final-modal'
import cards from "./Cards.vue";
import AddColumn from "./AddColumn.vue";
import $api from './../api.js';
export default {
	name:"columns",
	setup: () => ({
        title: 'Welcome to Trello Board'
    }),
	components: {
		ModalsContainer,
		cards,
		AddColumn
	},
    data(){
        return {
            columns:{},
        }
    },
    mounted(){
        this.getColumns()
    },
    methods:{
        async getColumns(){
            await $api.get('/columns').then(response=>{
                this.columns = response.data
            }).catch(error=>{
                console.log(error)
                this.columns = {}
            })
        },
		openmodal(){
			const _self = this;
			this.$vfm.show({ 
				component: AddColumn,
				on: {
				  // event by custom-modal
				  confirm(data, close) {
					console.log(data.title)
					let newColumn = {
						name: data.title
					}
					$api.post('/column/save', newColumn).then(response=>{
						_self.getColumns();
						console.log(response)
						
					}).catch(error=>{
						console.log(error)
					})
					close()
				  },
				  cancel(close) {
					console.log('cancel')
					close()
				  },
				}
			})
		},
		delete_column(columnId){
            if(confirm("Are you sure to delete this column ?")){
                $api.post(`/deletecolumn/${columnId}`).then(response=>{
                    this.getColumns()
                }).catch(error=>{
                    console.log(error)
                })
            }
        },
		exportdb(){
			console.log("exportdb called")
			$api.get('/export').then(response=>{
				console.log("exported")
			}).catch(error=>{
				console.log(error)
			})
		}
    }
}
</script>