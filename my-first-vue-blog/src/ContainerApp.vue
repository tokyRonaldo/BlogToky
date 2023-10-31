
<template>
<NavbarApp v-if="this.isAuth == false && this.isDashboard != true"  />
<NavbarAuthApp v-if="this.isAuth == true" />
<router-view></router-view>
<FooterApp v-if="this.isAuth == false" />
</template>
<script>
import NavbarApp from './layouts/NavbarApp.vue'
import NavbarAuthApp from './layouts/NavbarAuthApp.vue'
import FooterApp from './layouts/FooterApp.vue'
//import AccueilApp from './layouts/AccueilApp.vue'
//import DashboardApp from './admin/dashboard/DashboardApp.vue'


export default {
  name: 'ContainerApp',
components: {
    NavbarApp,
    NavbarAuthApp,
    //AccueilApp,
    FooterApp,
    //DashboardApp,
  },

    data() {
    return {
      message: 'Bonjour depuis le composant App!',
      isAuth : false,
      isDashboard : false
    };
  },
   methods: {
    ifIsAuth(routeName){
        if(routeName == 'app_login' || routeName == 'app_register'){
          
          this.isAuth = true;
        }
        else{
          this.isAuth = false;
        }
    },
    ifIsDashboard(routeName){
      if(routeName && routeName.startsWith("dashboard")){
        this.isDashboard = true;
      }
      else{
        this.isDashboard=false;
      }
    }
  },
   mounted() {
      //const routeName = this.$route.name;
    //this.ifIsDashboard(routeName);
  },
    watch: {
    '$route.name': {
      immediate: true, // Pour que le watcher se déclenche immédiatement après la création du composant
      handler(newParams) {
        this.ifIsAuth(newParams);
        console.log(newParams)
        this.ifIsDashboard(newParams);
       
      }
    }
    }
}
</script>


