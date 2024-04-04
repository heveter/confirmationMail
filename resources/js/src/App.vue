<script>
import {defineComponent} from "vue";


export default defineComponent({
    component: {},
    data: () => {
        return {
            bearerToken: '1|AdNKjjLkAmWEBFYXI0JZyRAgPWdgwG27uRgo3esGd2c88b72',
            notificationTypes: [],
            notificationType: null,
            confirmCode: null,
            step: 'select-notification-type'
        }
    },
    methods: {
        sendConfirmCode() {
            axios.post('api/auth/send-confirm-code', {
                'type': this.notificationType
            }, {
                headers: {
                    Authorization: 'Bearer ' + this.bearerToken,
                }
            })
            this.step = 'confirm-code'
        },
        confirm() {
            // TODO: отправляем код на бек, для подтверждения
          this.step = 'finish'
        },
        getNotificationTypes() {
            axios.get('api/auth/get-confirm-methods', {
                headers: {
                    Authorization: 'Bearer '  + this.bearerToken,
                }
            }).then(res => {
                this.notificationTypes.push(...res.data)
            })

            console.log(this.notificationTypes)
        }
    },
    created() {
        this.getNotificationTypes()
    }
});
</script>

<template>
    <div class="container-sm p-3">
        <div class="card" v-if="step === 'select-notification-type'">
            <div class="card-body">
                <h4>Выберите тип подтверждения</h4>
                <select class="mt-2 form-select" placeholder="Выберите тип подтверждения" v-model="notificationType">
                    <option v-for="type in notificationTypes" :value="type.value" >{{ type.name }}</option>
                </select>
                <button class="btn btn-primary mt-2" @click="sendConfirmCode">Отправить</button>
            </div>
        </div>
        <div class="card" v-else-if="step === 'confirm-code'">
            <div class="card-body">
                <h4>Введите код подтверждения</h4>
                <p class="mt-2">Код подтверждения отправлен на {{ notificationType }}</p>
                <input class="form-control mt-2" v-model="confirmCode" placeholder="Введите код подтверждения"/>
                <button class="btn btn-primary mt-2" @click="confirm">Подтвердить</button>
            </div>
        </div>
        <div class="card" v-else-if="step==='finish'">
            <div class="card-body">
                <h4>Код подтвержден</h4>
            </div>
        </div>
    </div>

</template>

<style lang="less" scoped>

</style>
