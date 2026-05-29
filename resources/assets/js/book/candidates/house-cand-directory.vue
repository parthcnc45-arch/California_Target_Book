<script>
  import axios from 'axios';

  export default {

    props: [],

    data: () => ({
      isLoading: true,
      year: 2018,
      query: '',
      candidates: [],
    }),

    computed: {
      tableSettings() {
        return {
          columns: [
            { data: 'CAND_NAME' },
            { data: 'CAND_PTY_AFFILIATION' },
            { data: 'fourcode' },
            { data: 'role' },
            { data: 'address' },
            {
              data: 'raised',
              render: (data) => {
                return `$${data.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")}`;
              }
            }, {
              data: 'spent',
              render: (data) => {
                return `$${data.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")}`;
              }
            }, {
              data: 'CAND_ID',
              render: (id) => {
                return `<a href="http://classic.fec.gov/fecviewer/CommitteeDetailFilings.do?tabIndex=3&candidateCommitteeId=${id}" target="_blank">${id}</a>`;
              }
            }, {
              data: 'CAND_PCC',
              render: (id) => {
                return `<a href="http://classic.fec.gov/fecviewer/CommitteeDetailFilings.do?tabIndex=3&candidateCommitteeId=${id}" target="_blank">${id}</a>`;
              }
            }
          ],
          data: this.candidates,
          query: this.query,
        };
      }
    },

    watch: {
      year() {
        this.doSearch();
      },
    },

    beforeMount() {
      this.doSearch();
    },

    mounted() {
    },

    methods: {
      async doSearch() {
        this.isLoading = true;
        this.candidates.splice(0, this.candidates.length);
        const res = await axios.get('/api/candidates/house?year=' + this.year);

        this.candidates.splice(0, this.candidates.length, ...res.data);
        this.isLoading = false;
      },
    },

  }
</script>


