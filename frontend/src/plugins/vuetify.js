import Vue from 'vue';
import Vuetify from 'vuetify/lib/framework';


Vue.use(Vuetify);

export default new Vuetify({
    theme: {
        themes: {
            light: {
              primary: "#094776" //#448aff
            },
          },
        options: {
          customProperties: true,
        },
        // ...
        fonts: {
          // Specify the Poppins font family
          family: 'Poppins',
          // Specify the font weights you want to use (optional)
          // weights: ['300', '400', '500', '700'],
        },
        // ...
      },
});
