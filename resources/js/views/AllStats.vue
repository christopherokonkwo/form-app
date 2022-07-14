<template>
    <section>
        <page-header />

        <main class="py-4">
            <div class="col-xl-8 offset-xl-2 col-lg-10 offset-lg-1 col-md-12">
                <div class="d-flex justify-content-between mt-2 mb-4 align-items-center">
                    <div>
                        <h3 class="mt-2">{{ trans.stats }}</h3>
                        <p class="mt-2 text-secondary">
                            {{ trans.click_to_see_insights }}
                        </p>
                    </div>

                    <!-- <select
                        v-model="scope"
                        id="scope"
                        v-if="isReady && isAdmin"
                        name="scope"
                        class="ml-auto w-auto custom-select border-0 bg-light"
                        @change="changeScope"
                    >
                        <option value="user">{{ trans.your_stats }}</option>
                        <option value="all">{{ trans.all_stats }}</option>
                    </select> -->
                </div>

                <div v-if="isReady">
                    <div class="row mt-4 pt-2">
                        <div v-if="isAdmin" class="col-md-4 mb-4">
                            <div class="card shadow-lg">
                                <div
                                    class="card-header pb-0 bg-transparent d-flex justify-content-between align-middle border-0"
                                >
                                    <p class="font-weight-bold text-muted small text-uppercase">
                                        {{ trans.reports_all }}
                                    </p>
                                </div>
                                <div class="card-body pt-0 pb-2">
                                    <p class="card-text display-4">{{ suffixedNumber(data.all_reports) }}</p>
                                </div>
                            </div>
                        </div>

                        <div v-if="isAdmin" class="col-md-4 mb-4">
                            <div class="card shadow-lg">
                                <div
                                    class="card-header pb-0 bg-transparent d-flex justify-content-between align-middle border-0"
                                >
                                    <p class="font-weight-bold text-muted small text-uppercase">
                                        {{ trans.reports_pending }}
                                    </p>
                                </div>
                                <div class="card-body pt-0 pb-2">
                                    <p class="card-text display-4">
                                        {{ suffixedNumber(data.pending_reports) }}
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4 mb-4">
                            <div class="card shadow-lg">
                                <div
                                    class="card-header pb-0 bg-transparent d-flex justify-content-between align-middle border-0"
                                >
                                    <p class="font-weight-bold text-muted small text-uppercase">
                                        {{ trans.reports_assigned }}
                                    </p>
                                </div>
                                <div class="card-body pt-0 pb-2">
                                    <p class="card-text display-4">
                                        {{ suffixedNumber(data.assigned_reports) }}
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4 mb-4">
                            <div class="card shadow-lg">
                                <div
                                    class="card-header pb-0 bg-transparent d-flex justify-content-between align-middle border-0"
                                >
                                    <p class="font-weight-bold text-muted small text-uppercase">
                                        {{ trans.reports_resolved }}
                                    </p>
                                </div>
                                <div class="card-body pt-0 pb-2">
                                    <p class="card-text display-4">
                                        {{ suffixedNumber(data.resolved_reports) }}
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4 mb-4">
                            <div class="card shadow-lg">
                                <div
                                    class="card-header pb-0 bg-transparent d-flex justify-content-between align-middle border-0"
                                >
                                    <p class="font-weight-bold text-muted small text-uppercase">
                                        {{ trans.reports_personal }}
                                    </p>
                                </div>
                                <div class="card-body pt-0 pb-2">
                                    <p class="card-text display-4">{{ suffixedNumber(data.my_reports) }}</p>
                                </div>
                            </div>
                        </div>
                        <!-- <div class="card shadow-lg">
                            <div
                                class="card-header pb-0 bg-transparent d-flex justify-content-between align-middle border-0"
                            >
                                <p class="font-weight-bold text-muted small text-uppercase">{{ trans.visitors }}</p>
                                <p>
                                    <span class="badge badge-pill badge-primary p-2 font-weight-bold">{{
                                        trans.last_thirty_days
                                    }}</span>
                                </p>
                            </div>
                            <div class="card-body pt-0 pb-2">
                                <p class="card-text display-4">{{ suffixedNumber(data.visits) }}</p>
                            </div>
                        </div> -->
                    </div>
                    <!-- <div class="card bg-light mb-3" style="max-width: 18rem">
                        <div class="card-header">Header</div>
                        <div class="card-body">
                            <h5 class="card-title">Light card title</h5>
                            <p class="card-text">
                                Some quick example text to build on the card title and make up the bulk of the card's
                                content.
                            </p>
                        </div>
                    </div>
                    <div class="card text-white bg-dark mb-3" style="max-width: 18rem">
                        <div class="card-header">Header</div>
                        <div class="card-body">
                            <h5 class="card-title">Dark card title</h5>
                            <p class="card-text">
                                Some quick example text to build on the card title and make up the bulk of the card's
                                content.
                            </p>
                        </div>
                    </div> -->

                    <!-- <line-chart :views="plotViewPoints" :visits="plotVisitPoints" class="mt-5" /> -->
                </div>
            </div>
        </main>
    </section>
</template>

<script>
import { mapGetters } from 'vuex';
import Hover from '../directives/Hover';
import InfiniteLoading from 'vue-infinite-loading';
import NProgress from 'nprogress';
import PageHeader from '../components/PageHeader';
import strings from '../mixins/strings';

export default {
    name: 'all-stats',

    components: {
        InfiniteLoading,
        PageHeader,
    },

    directives: {
        Hover,
    },

    mixins: [strings],

    data() {
        return {
            page: 1,
            reports: [],
            data: null,
            scope: 'user',
            infiniteId: +new Date(),
            isReady: false,
        };
    },

    computed: {
        ...mapGetters({
            isAdmin: 'settings/isAdmin',
            trans: 'settings/trans',
        }),

        hasReports() {
            return this.reports.length > 0;
        },

        // plotViewPoints() {
        //     return JSON.parse(this.data.graph.views);
        // },

        // plotVisitPoints() {
        //     return JSON.parse(this.data.graph.visits);
        // },
    },

    async created() {
        await Promise.all([this.fetchStats()]);
        this.isReady = true;
        NProgress.done();
    },

    methods: {
        fetchStats() {
            return this.request()
                .get('/api/stats', {
                    params: {
                        scope: this.scope,
                    },
                })
                .then(({ data }) => {
                    this.data = data;
                    NProgress.inc();
                })
                .catch(() => {
                    NProgress.done();
                });
        },

        async changeScope() {
            this.isReady = false;
            this.data = null;
            this.page = 1;
            this.reports = [];
            await Promise.all([this.fetchStats()]);
            this.infiniteId += 1;
            this.isReady = true;
            NProgress.done();
        },
    },
};
</script>

<style scoped lang="scss">
@import '../../sass/utilities/variables';

.badge-success {
    background-color: $green-500;
    color: darken($green, 20%);
}

.badge-primary {
    background-color: $blue-500;
    color: darken($blue, 35%);
}
</style>
