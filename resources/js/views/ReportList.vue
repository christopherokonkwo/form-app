<template>
    <section>
        <page-header />

        <main class="py-4">
            <div class="col-xl-8 offset-xl-2 col-lg-10 offset-lg-1 col-md-12">
                <div class="my-3">
                    <h3 class="mt-3">{{ trans.reports }}</h3>

                    <p class="mt-2 text-secondary">
                        {{ trans.reports_are_great_for }}
                    </p>
                    <export-excel
                        v-if="isAdmin"
                        class="btn btn-success"
                        :name="'incident-reports-' + moment(new Date()).format('DD-MM-YYYY-h-m-sa') + '.csv'"
                        :data="reports"
                        :fields="json_fields"
                        type="csv"
                        worksheet="My Worksheet"
                    >
                        Export to CSV
                    </export-excel>
                    <export-excel
                        v-if="isAdmin"
                        class="btn btn-success"
                        :data="reports"
                        :fields="json_fields"
                        worksheet="My Worksheet"
                        :name="'incident-reports-' + moment(new Date()).format('DD-MM-YYYY-h-m-sa') + '.xls'"
                    >
                        Export to Excel
                    </export-excel>
                </div>

                <div v-if="isReady" class="mt-5 card shadow-lg">
                    <div class="card-body p-0">
                        <div :key="`${index}-${report.id}`" v-for="(report, index) in reports">
                            <router-link
                                :to="{
                                    name: 'edit-report',
                                    params: { id: report.id },
                                }"
                                class="text-decoration-none"
                            >
                                <div
                                    v-hover="{ class: `hover-bg` }"
                                    class="p-3"
                                    :class="{
                                        'border-top': index !== 0,
                                        'rounded-top': index === 0,
                                        'rounded-bottom': index === reports.length - 1,
                                    }"
                                >
                                    <div class="d-flex align-items-center">
                                        <div class="mr-auto pl-2">
                                            <p class="mb-0 py-1 lead font-weight-bold text-truncate">
                                                {{ report.name }}
                                            </p>
                                            <span v-if="reportType(report)" class="badge badge-pill badge-primary"
                                                >My report</span
                                            >
                                            <span v-if="pending(report)" class="badge badge-pill badge-secondary"
                                                >Pending</span
                                            >
                                            <span v-if="assigned(report)" class="badge badge-pill badge-warning"
                                                >Assigned</span
                                            >
                                            <span v-if="assigned(report)" class="badge badge-pill badge-info"
                                                >In progress</span
                                            >
                                            <span v-if="done(report)" class="badge badge-pill badge-success"
                                                >Resolved</span
                                            >
                                        </div>
                                        <div class="ml-auto d-none d-md-inline-block">
                                            <span class="mr-3"
                                                >{{ trans.created }}
                                                {{ moment(report.created_at).format('MMM D, YYYY') }}</span
                                            >
                                        </div>

                                        <svg
                                            xmlns="http://www.w3.org/2000/svg"
                                            width="25"
                                            viewBox="0 0 24 24"
                                            class="icon-cheveron-right-circle"
                                        >
                                            <circle cx="12" cy="12" r="10" style="fill: none" />
                                            <path
                                                class="fill-light-gray"
                                                d="M10.3 8.7a1 1 0 0 1 1.4-1.4l4 4a1 1 0 0 1 0 1.4l-4 4a1 1 0 0 1-1.4-1.4l3.29-3.3-3.3-3.3z"
                                            />
                                        </svg>
                                    </div>
                                </div>
                            </router-link>
                        </div>

                        <infinite-loading spinner="spiral" @infinite="fetchReports">
                            <span slot="no-more" />
                            <div slot="no-results" class="text-left">
                                <div class="my-5">
                                    <p class="lead text-center text-muted mt-5">
                                        {{ trans.you_have_no_reports }}
                                    </p>
                                </div>
                            </div>
                        </infinite-loading>
                    </div>
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
import isEmpty from 'lodash/isEmpty';
import strings from '../mixins/strings';

export default {
    name: 'report-list',

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
            isReady: false,
            json_fields: {
                'Full Name': 'name',
                'Phone Number': 'phone',
                Location: 'location',
                Status: 'status',
                'Additional Notes': 'additional_notes',
                'Recieved By': 'recieved_by.name',
                'Reported By': 'user.name',
                'Assigned To': 'assigned_user.name',
                'Assigned Date': 'assigned_at',
                'Reported Date': {
                    field: 'created_at',
                    callback: (date) => {
                        return this.moment(date).format('DD-MM-YYYY h:ma');
                    },
                },
                'Machine Details': {
                    field: 'machines',
                    callback: (machines) => {
                        return machines
                            .map(
                                (machine) =>
                                    `Type: ${machine.type}, Number: ${machine.number}, Detail: ${machine.details}`
                            )
                            .join(' | ');
                    },
                },
                // 'Recieved By': {
                //     field: 'recieved_by.name',
                //     callback: (value) => {
                //         return `Landline Phone - ${value}`;
                //     },
                // },
            },
        };
    },

    computed: {
        ...mapGetters({
            trans: 'settings/trans',
            isAdmin: 'settings/isAdmin',
            isEditor: 'settings/isEditor',
            user: 'settings/user',
        }),
    },

    async created() {
        await Promise.all([this.fetchReports()]);
        this.isReady = true;
        NProgress.done();
    },

    methods: {
        fetchReports($state) {
            if ($state) {
                return this.request()
                    .get('/api/reports', {
                        params: {
                            page: this.page,
                        },
                    })
                    .then(({ data }) => {
                        if (!isEmpty(data) && !isEmpty(data.data)) {
                            this.page += 1;
                            this.reports.push(...data.data);

                            $state.loaded();
                        } else {
                            $state.complete();
                        }

                        if (isEmpty($state)) {
                            NProgress.inc();
                        }
                    })
                    .catch(() => {
                        NProgress.done();
                    });
            }
        },

        assigned(report) {
            return report.status == 'assigned';
        },
        pending(report) {
            return report.status == 'pending';
        },
        done(report) {
            return report.status == 'done';
        },
        reportType(report) {
            return (this.isAdmin || this.isEditor) && report.user_id === this.user.id;
        },
    },
};
</script>
