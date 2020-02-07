<template>
<div>
    <modal-users v-on:result="getUsers" :key="(new Date()).getTime()" :groups="groups" :config="configModal"></modal-users>
    <div class="row">
        <div class="col-sm-12 col-md-4 col-lg-4">
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>{{num_rows}}</h3>
                    <p>Usuários Registrados</p>
                </div>
                <div class="icon">
                    <i class="fas fa-fw fa-user"></i>
                </div>
                <a href="#" data-toggle="modal" data-target="#modal-users" class="small-box-footer">Adicionar Usuário <i class="fas fa-plus"></i></a>
            </div>  
        </div>
        <div class="col-12">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nome</th>
                        <th>Email</th>
                        <th>Grupo</th>
                        <th>Criado em</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                
                <tbody>
                    <tr v-for="(u, index) in users" :key="index">
                        <td>{{++index}}</td>
                        <td>{{u.name}}</td>
                        <td>{{u.email}}</td>
                        <td>{{u.users_group.name}}</td>
                        <td>{{u.created_at | datebr}}</td>
                        <td>
                            <a @click.prevent="editUser(u)" data-toggle="modal" data-target="#modal-users" title="Editar usuário">
                                <i class="fa fa-edit"></i>
                            </a>
                        </td>
                    </tr>
                </tbody>

            </table>
        </div>
    </div>
</div>
</template>
<script>

import ModalUsers from './ModalUsers';
import Swal from 'sweetalert2';
import * as helpers from '../../helpers';
export default {
    components:{
        ModalUsers
    },
    props:['groups'],
    data () {
        return {
            users:[],
            num_rows:0,
            configModal:{
                modalTitle: 'Adicionar Usuário', 
                modalSize: 'modal-md'
            }
        }
    },
    methods:{
        getUsers () {
            axios.get('users/list').then(res =>{
                this.num_rows = res.data.num_rows;
                this.users = res.data.users;
            });
        },
        editUser(u) {
            this.configModal = {
                modalTitle: 'Atualizar Usuário', 
                modalSize: 'modal-md',
                data:u,
                action:'update',
            }
        }
    },
    mounted () {
        this.getUsers();
    },
    filters : {
        datebr (value) {
            return helpers.dateBr(value);
        }
    },
    beforeMount() {
        $(document).ready( function () {
           // $('table').DataTable();
        });

    }
}
</script>

<style>

</style>