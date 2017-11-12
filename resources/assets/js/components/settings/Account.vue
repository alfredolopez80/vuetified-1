<template>
    <v-tabs-content
          id="account"
    >
        <v-container>
            <v-layout row wrap>
                <p class="primary--text">Account Details</p>
                <v-flex xs12>
                    <v-alert color="primary" icon="fa-link" value="true">
                        <v-list dense light class="primary">
                            <v-link  link-color="white" :dark="false"  :title="`Your Online Shop Link : ${href}`" :href="href"></v-link>
                        </v-list>
                    </v-alert>
                </v-flex>
                <v-flex xs12>
                    <v-text-field
                    label="Username"
                    v-model="username"
                    light
                    >
                    </v-text-field>
                </v-flex>
                <v-flex xs12>
                    <v-text-field
                    label="Email"
                    v-model="email"
                    light
                    >
                    </v-text-field>
                </v-flex>
                <v-flex xs12>
                    <v-text-field
                    label="Account Name"
                    v-model="name"
                    light
                    >
                    </v-text-field>
                </v-flex>
                <v-flex xs12>
                    <v-text-field
                    label="Old Password"
                    v-model="old_password"
                    light
                    >
                    </v-text-field>
                </v-flex>
                <v-flex xs12>
                    <v-text-field
                    label="New Password"
                    v-model="password"
                    light
                    >
                    </v-text-field>
                </v-flex>
                <v-flex xs12>
                    <v-text-field
                    label="Confirm New Password"
                    v-model="password_confirmation"
                    light
                    >
                    </v-text-field>
                </v-flex>
                <v-btn block color="primary" @click="updateAccount()">
                    Update Account <v-icon right>fa-send</v-icon>
                </v-btn>
            </v-layout>
        </v-container>
    </v-tabs-content>
</template>

<script>
import VLink from '../VLink.vue'
import { createNamespacedHelpers } from 'vuex'
const { mapGetters, mapMutations } = createNamespacedHelpers('auth')

export default {
    data: () => ({
        accountForm: new AppForm(App.forms.accountForm),
        name: null,
        email: null,
        username: null,
        old_password: null,
        password: null,
        password_confirmation: null
    }),
    computed: {
        ...mapGetters({
            getMe: 'getMe'
        }),
        href () {
            return `http://${this.username}.${App.site.domain}`
        }
    },
    components: {
        VLink
    },
    mounted () {
        let self = this
        self.name = self.getMe.name
        self.email = self.getMe.email
        self.username = self.getMe.username
    },
    methods: {
        ...mapMutations({
            setMe: 'setMe'
        }),
        prepareAccountForm () {
            let self = this
            self.accountForm.name = self.name
            self.accountForm.username = self.username
            self.accountForm.email = self.email
            self.accountForm.old_password = self.old_password
            self.accountForm.password = self.password
            self.accountForm.password_confirmation = self.password_confirmation
            if (self.old_password === null) {
                delete self.accountForm.old_password
                delete self.accountForm.password
                delete self.accountForm.password_confirmation
            }
        },
        resetAccountForm () {
            let self = this
            self.accountForm = new AppForm(App.forms.accountForm)
        },
        async updateAccount () {
            let self = this
            self.accountForm.busy = true
            self.prepareAccountForm()
            try {
                const payload = (await App.post(route('api.user.updateAccount'), self.accountForm))
                self.resetAccountForm()
                self.setMe(payload.data)
                vm.$popup({ message: payload.message, backgroundColor: '#4db6ac', delay: 5, color: '#fffffa' })
            } catch ({errors, message}) {
                self.accountForm.errors.set(errors)
                self.accountForm.busy = false
                vm.$popup({ message: message, backgroundColor: '#e57373', delay: 5, color: '#fffffa' })
            }
        }
    }
}
</script>

<style>

</style>