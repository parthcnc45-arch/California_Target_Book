
<script>
  import storeService from '../services/store.service';

  export default {

    props: ['current'],

    data: () => ({
      activeNav: '',
      showNav: true,
      subMenus: {
        district: '',
        stats: '',
        propositions: '',
        finance: '',
      },
      verboseMode: false,
      showExtras: true,
    }),

    watch: {
      verboseMode(val) {
        storeService.set('verboseMode', val);
      },
    },

    beforeMount() {
      this.activeNav = this.current;
      this.restoreSettings();
    },
    mounted() {
      const $sectionNav = $(this.$el).find(`#${this.activeNav}-nav`);
      this.showNav = !!$sectionNav[0] && window.innerWidth > 768;
      this.findSubMenu();

      setTimeout(() => {
        this.showExtras = true;
      }, 100);
    },

    methods: {

      restoreSettings() {
        this.verboseMode = storeService.get('verboseMode');
      },

      findSubMenu() {
        const $current = $(`a[href$="${window.location.pathname}"]`);
        $current.addClass('current');

        const $dropdown = $('li.dropdown:has(a.current)');
        this.subMenus[this.activeNav] = $dropdown.data('submenu');

        setTimeout(() => {
          const offset = $dropdown.find('ul.dropdown-menu li:has(a.current)').offset();
          if (!offset) return;
          $dropdown.find('ul.dropdown-menu:has(a.current)').scrollTop(offset.top - 200);
        }, 100);
      },
      setNav(n) {
        this.activeNav = n;
        this.showNav = true;
      },
      setSubMenu(sub) {
        if (sub === this.subMenus[this.activeNav]) {
          this.subMenus[this.activeNav] = '';
        } else {
          this.subMenus[this.activeNav] = sub;
        }
      },
      show(pane) {
        return this.activeNav === pane && this.showNav;
      },
    },
  }

</script>
