import HeaderMenu from "./components/HeaderMenu.vue";
import Services from "./components/Services.vue";
import Products from "./components/Products.vue";
import Application from "./components/Application.vue";
import Reviews from "./components/Reviews.vue";
import NavData from "./components/NavData.vue";

import "../css/header.less";
import "../css/footer.less";
import "../css/hero.less";
import "../css/popup-admin.less";
import "../css/do.less";
import "../css/contacts.less";
import "../css/application.less";
import "../css/popup-success.less";
import "../css/review.less";
import "../css/clients.less";
import "../css/nav-data.less";
import "../css/data.less";
import "../css/edit.less";

import {createApp} from "vue";

function vueInit(vueEl, component) {
    if (!vueEl) return;

    const props = JSON.parse(vueEl.dataset.vue || '{}');

    const app = createApp(component, props);

    const componentContainer = document.createElement(vueEl.tagName);

    componentContainer.className = vueEl.className;

    vueEl.replaceWith(componentContainer);

    app.mount(componentContainer);
}



vueInit(document.querySelector('.vue-header-menu'), HeaderMenu);
vueInit(document.querySelector('.vue-services'), Services);
vueInit(document.querySelector('.vue-popup-products'), Products);
vueInit(document.querySelector('.vue-application'), Application);
vueInit(document.querySelector('.vue-popup-review'), Reviews);
vueInit(document.querySelector('.vue-nav-data'), NavData);
