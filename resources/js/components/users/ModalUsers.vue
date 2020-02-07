<template>
    <div class="modal" tabindex="-1" role="dialog" id="modal-users">
        <div class="modal-dialog" :class="config.modalSize" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{config.modalTitle}}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="" v-if="errors.length>0" v-html="errors">{{errors}}</div>
                <div class="row">
                    <div class="col-sm-12 col-md-12 col-lg-12 form-group">
                        <label for="name">Nome</label>
                        <input type="text" id="name" class="form-control" minlength="5" v-model='user.name' >
                    </div>
                    <div class="col-sm-12 col-md-12 col-lg-12 form-group">
                        <label for="email">Email</label>
                        <input type="email" id="email" class="form-control" v-model="user.email" >
                    </div>

                    <div class="col-sm-12 col-md-12 col-lg-12 form-group">
                        <label for="user_group">Grupo</label>
                        <select id="user_group" class="form-control" v-model="user.users_group_id">
                            <option value="0">selecione</option>
                            <option v-for="g in groups" :key="g.id" :value="g.id">{{g.name}}</option>
                        </select>
                    </div>

                    <div v-if="config.action != 'update'" class="col-sm-12 col-md-6 col-lg-6">
                        <label for="password">Senha</label>
                        <input type="password" id="password" autocomplete="off" class="form-control" v-model="user.password" >
                    </div>

                    <div v-if="config.action != 'update'" class="col-sm-12 col-md-6 col-lg-6">
                        <label for="c_password">Confirmar Senha</label>
                        <input type="password" id="c_password" autocomplete="off" class="form-control" v-model="user.c_password" >
                    </div>
                    


                </div>
            </div>
            <div class="modal-footer">
                <button type="button" v-if="config.action == 'update'" @click="deleteUser(config.data)" class="btn btn-danger btn-modal" data-dismiss="modal">
                    <i class="fa fa-lock"></i>
                    Desativar
                </button>
                

                <button type="button" class="btn btn-primary btn-modal" @click="submit">
                    <i class="fa fa-save left"></i>
                   <span v-if="config.action != 'update'">Adicionar</span>
                   <span v-else>Atualizar</span>
                </button>
                
            </div>
            </div>
        </div>
    </div>
</template>

<script>
import * as helpers from '../../helpers';
import alerts from '../../alerts';
import Swal from 'sweetalert2'
export default {
    props:['config', 'groups'],
    data () {
        return {
            user:{
                users_group_id:0,
            },
            errors:[]
        }
    },
    methods:{
        submit () {
            if(helpers.isEmpty(this.user.name)){
                toast.fire({
                    icon: 'error',
                    title: 'O nome do usuário é obrigatório'
                });
                return ;
            }
            if(this.user.name.length < 5){
                toast.fire({
                    icon: 'error',
                    title: 'O nome deve ter no mínimo 5 caracteres'
                });
                return ;
            }
            if(!helpers.isEmail(this.user.email)){
                toast.fire({
                    icon: 'error',
                    title: 'Insira um email válido'
                });
                return ;
            }

            if(this.user.users_group_id == 0){
                toast.fire({
                    icon: 'error',
                    title: 'Selecione o grupo do usuário'
                });
                return ;
            }
            if(this.config.action == 'update'){
                this.update(); return
            } 
            this.save();
        },
        update () {
            axios.put(`users/update/${this.config.data.id}`, this.user).then((res)=>{
                toast.fire({
                    icon: 'success',
                    title: 'Usuário alterado com sucesso'
                });
                this.$emit('result');
                $('#modal-users').modal('hide')
            }, (err) => {
                this.errors = alerts.errors(err.response.data);
            });
            
        },
        save () {    
            axios.post('users/save', this.user).then((res)=>{
                toast.fire({
                    icon: 'success',
                    title: 'Usuário cadastrado com sucesso'
                });
                this.$emit('result');
                $('#modal-users').modal('hide')

            }, (err) => {
                this.errors = alerts.errors(err.response.data);
            });
        },
        deleteUser(u) {
            Swal.fire({
                title: 'Atenção',
                text: `Você deseja desativar o usuário de(a) ${u.name}?`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Desativar',
                cancelButtonText:'Cancelar'
            }).then((result) => {
                if (result.value) {
                    axios.delete(`users/delete/${u.id}`).then(res =>{
                        Swal.fire(
                            'Desativado!',
                            'O usuário foi desativado com sucesso',
                            'success'
                        );
                        this.$emit('result');
                    });
                }
            });
        },
    },
    mounted () {
        if(this.config.action == 'update') {
            Object.assign(this.user, this.config.data);
        }
    }
}
</script>

<style>

</style>

