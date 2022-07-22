<template>
    <section>
        <page-header>
            <template slot="options">
                <div v-if="!creatingReport" class="dropdown">
                    <a
                        id="navbarDropdown"
                        class="nav-link pr-0"
                        href="#"
                        role="button"
                        data-toggle="dropdown"
                        aria-haspopup="true"
                        aria-expanded="false"
                    >
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 24 24"
                            width="25"
                            class="icon-dots-horizontal"
                        >
                            <path
                                class="fill-light-gray"
                                fill-rule="evenodd"
                                d="M5 14a2 2 0 1 1 0-4 2 2 0 0 1 0 4zm7 0a2 2 0 1 1 0-4 2 2 0 0 1 0 4zm7 0a2 2 0 1 1 0-4 2 2 0 0 1 0 4z"
                            />
                        </svg>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
                        <a href="#" class="dropdown-item text-danger" @click="showDeleteModal"> {{ trans.delete }} </a>
                    </div>
                </div>
            </template>
        </page-header>

        <main class="py-4">
            <div class="col-xl-8 offset-xl-2 col-lg-10 offset-lg-1 col-md-12">
                <div v-if="isReady" class="my-3">
                    <h3 class="mt-3">
                        <router-link :to="{ name: 'reports' }" class="text-decoration-none text-muted">{{
                            trans.reports
                        }}</router-link>
                        <span class="text-muted"> / </span>
                        {{ title }}
                    </h3>
                    <p v-if="!creatingReport" class="mt-2 text-secondary">
                        {{ trans.last_updated }} {{ moment(report.updated_at).fromNow() }}
                    </p>
                </div>

                <div v-if="isReady" class="mt-5 card shadow-lg">
                    <div class="card-body">
                        <div class="col-12">
                            <div class="form-group row">
                                <label class="font-weight-bold text-uppercase text-muted small">
                                    {{ trans.name }}
                                </label>
                                <input
                                    v-model="report.name"
                                    type="text"
                                    name="name"
                                    autofocus
                                    autocomplete="off"
                                    title="Name"
                                    class="form-control border-0"
                                    :placeholder="trans.name"
                                    @keyup.enter="saveReport"
                                />
                            </div>
                            <div class="form-group row">
                                <label class="font-weight-bold text-uppercase text-muted small">
                                    {{ trans.machine_number }}
                                </label>
                                <input
                                    v-model="report.machine_number"
                                    type="text"
                                    name="machine_number"
                                    autofocus
                                    autocomplete="off"
                                    title="Machine Number"
                                    class="form-control border-0"
                                    :placeholder="trans.machine_number"
                                    @keyup.enter="saveReport"
                                />
                            </div>
                            <div class="form-group row">
                                <label class="font-weight-bold text-uppercase text-muted small">
                                    {{ trans.machine_type }}
                                </label>
                                <input
                                    v-model="report.machine_type"
                                    type="text"
                                    name="machine_type"
                                    title="Machine Number"
                                    class="form-control border-0"
                                    :placeholder="trans.machine_type"
                                    @keyup.enter="saveReport"
                                />
                            </div>
                            <div class="form-group row">
                                <label class="font-weight-bold text-uppercase text-muted small">
                                    {{ trans.phone }}
                                </label>
                                <input
                                    v-model="report.phone"
                                    type="text"
                                    name="phone"
                                    autocomplete="off"
                                    title="Phone"
                                    class="form-control border-0"
                                    :placeholder="trans.phone"
                                    @keyup.enter="saveReport"
                                />
                            </div>
                            <div class="form-group row">
                                <div class="col-5 pl-0">
                                    <label class="font-weight-bold text-uppercase text-muted small">
                                        {{ trans.date }}
                                    </label>
                                    <input
                                        v-model="moment(report.created_at).format('MMMM DD YYYY hh:mm A')"
                                        type="text"
                                        disabled
                                        title="date"
                                        class="form-control border-0"
                                        :placeholder="trans.date"
                                    />
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="font-weight-bold text-uppercase text-muted small">
                                    {{ trans.location }}
                                </label>
                                <input
                                    v-model="report.location"
                                    type="text"
                                    name="location"
                                    title="Location"
                                    class="form-control border-0"
                                    :placeholder="trans.location"
                                />
                            </div>
                            <div class="form-group row">
                                <label class="font-weight-bold text-uppercase text-muted small">{{
                                    trans.incident_details
                                }}</label>
                                <multiselect
                                    v-model="option"
                                    :options="details"
                                    :placeholder="trans.select_an_incident_detail"
                                    label="name"
                                    track-by="slug"
                                    style="cursor: pointer"
                                    @input="inputDetailOption"
                                />
                            </div>

                            <div class="form-group row">
                                <label class="font-weight-bold text-uppercase text-muted small">
                                    {{ trans.notes }}
                                </label>
                                <textarea
                                    v-model="report.additional_notes"
                                    type="text"
                                    name="additional_notes"
                                    title="Additional Notes"
                                    class="form-control border-0"
                                    :placeholder="trans.additional_notes"
                                ></textarea>
                            </div>
                            <div v-if="!creatingReport">
                                <hr class="mt-5" />
                                <h2 class="text-center mb-3">Officials Only Section</h2>

                                <div class="form-group row">
                                    <div class="col-12 col-md-8">
                                        <label class="font-weight-bold text-uppercase text-muted small">
                                            {{ trans.recieved_by }}
                                        </label>
                                        <input
                                            v-model="report.recieved_by"
                                            type="text"
                                            name="recieved_by"
                                            title="Recieved By"
                                            class="form-control border-0"
                                            :placeholder="trans.recieved_by"
                                            :disabled="!isAdmin"
                                        />
                                    </div>
                                    <div class="col-12 col-md-4">
                                        <label class="font-weight-bold text-uppercase text-muted small">
                                            {{ trans.assigned_at }}
                                        </label>
                                        <input
                                            :value="report.assigned_user ? moment(report.assigned_at).fromNow() : ''"
                                            :placeholder="trans.recieved_at"
                                            type="text"
                                            disabled
                                            title="Assigned Date"
                                            class="form-control border-0"
                                        />
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-12 col-md-4">
                                        <label class="font-weight-bold text-uppercase text-muted small">
                                            {{ trans.reported_by }}
                                        </label>
                                        <input
                                            v-model="report.user.name"
                                            type="text"
                                            disabled
                                            title="Reported By"
                                            class="form-control border-0"
                                        />
                                    </div>
                                    <div class="col-12 col-md-4">
                                        <label class="font-weight-bold text-uppercase text-muted small">
                                            {{ trans.assigned_to }}
                                        </label>
                                        <multiselect
                                            v-if="isAdmin"
                                            v-model="report.assigned_user"
                                            :options="assignees"
                                            :placeholder="trans.assigned_to"
                                            label="name"
                                            track-by="id"
                                            style="cursor: pointer"
                                            @input="saveReport"
                                        />
                                        <input
                                            v-else
                                            :value="report.assigned_user ? report.assigned_user.name : ''"
                                            disabled
                                            type="text"
                                            title="Assigned To"
                                            class="form-control border-0"
                                            :placeholder="trans.assigned_to"
                                        />
                                    </div>
                                    <div v-if="!creatingReport" class="col-12 col-md-4">
                                        <label class="font-weight-bold text-uppercase text-muted small">
                                            {{ trans.status }}
                                        </label>
                                        <multiselect
                                            v-if="canUpdateStatus"
                                            v-model="report.status"
                                            :options="reportStatus"
                                            :allow-empty="false"
                                            style="cursor: pointer"
                                            @input="saveReport"
                                        />
                                        <input
                                            v-else
                                            :value="report.status"
                                            disabled
                                            type="text"
                                            title="Report status"
                                            class="form-control border-0"
                                        />
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row mt-4 mb-2">
                                <div class="col-md px-0">
                                    <a
                                        href="#"
                                        onclick="this.blur()"
                                        class="btn btn-success btn-block font-weight-bold mt-0"
                                        :class="shouldDisableButton ? 'disabled' : ''"
                                        aria-label="Save"
                                        @click.prevent="saveReport"
                                    >
                                        {{ trans.save }}
                                    </a>
                                </div>
                                <div class="col-md px-0">
                                    <router-link
                                        :to="{ name: 'reports' }"
                                        class="btn btn-link btn-block font-weight-bold text-muted text-decoration-none"
                                    >
                                        {{ trans.cancel }}
                                    </router-link>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>

        <delete-modal
            ref="deleteModal"
            :header="trans.delete"
            :message="trans.deleted_reports_are_gone_forever"
            @delete="deleteReport"
        />
    </section>
</template>

<script>
import { mapGetters } from 'vuex';
import $ from 'jquery';
import DeleteModal from '../components/modals/DeleteModal';
import Hover from '../directives/Hover';
import InfiniteLoading from 'vue-infinite-loading';
import NProgress from 'nprogress';
import PageHeader from '../components/PageHeader';
import isEmpty from 'lodash/isEmpty';
import status from '../mixins/status';
import strings from '../mixins/strings';
import Multiselect from 'vue-multiselect';

export default {
    name: 'edit-report',

    components: {
        DeleteModal,
        InfiniteLoading,
        PageHeader,
        Multiselect,
    },

    directives: {
        Hover,
    },

    mixins: [status, strings],

    data() {
        return {
            uri: this.$route.params.id || 'create',
            report: {},
            page: 1,
            errors: [],
            isReady: false,
            details: [
                { name: 'Buttons', slug: 'buttons' },
                { name: 'Chairs', slug: 'chairs' },
                { name: 'Door Keys', slug: 'door_keys' },
                { name: 'Electronic Keys', slug: 'electronic_keys' },
            ],
            option: {},
            assignees: [],
        };
    },

    computed: {
        ...mapGetters({
            trans: 'settings/trans',
            user: 'settings/user',
            isAdmin: 'settings/isAdmin',
            isEditor: 'settings/isEditor',
        }),
        reportStatus() {
            if (this.isAdmin) {
                return ['pending', 'assigned', 'done'];
            } else {
                return ['assigned', 'done'];
            }
        },

        canUpdateStatus() {
            return this.isAdmin || this.report.assigned_to == this.user.id;
        },

        creatingReport() {
            return this.$route.name === 'create-report';
        },

        shouldDisableButton() {
            return isEmpty(this.report.name);
        },

        title() {
            if (this.creatingReport) {
                return this.report.name || this.trans.new_report;
            } else {
                return this.report.name || this.trans.edit_report;
            }
        },

        invalidSlug() {
            if (!isEmpty(this.errors.slug) && this.errors.slug.length > 0) {
                return {
                    error: this.errors.slug[0],
                    shouldShow: true,
                };
            }

            return {
                error: null,
                shouldShow: false,
            };
        },

        reportAssignedTo() {
            return this.report.assignedTo ? this.report.assignedTo.name : '';
        },
    },

    watch: {
        'report.name'(val) {
            this.report.slug = !isEmpty(val) ? this.slugify(val) : '';
        },

        async $route(to) {
            if (this.uri === 'create' && to.params.id === this.report.id) {
                this.uri = to.params.id;
            }

            if (this.uri !== to.params.id) {
                this.isReady = false;
                this.uri = to.params.id;
                this.page = 1;
                await Promise.all([this.fetchReport()]);
                this.isReady = true;
                NProgress.done();
            }
        },
    },

    async created() {
        await Promise.all([this.fetchReport()]);
        this.isReady = true;
        this.option = this.details.find((item) => item.slug);
        NProgress.done();
    },

    methods: {
        fetchReport() {
            return this.request()
                .get(`/api/reports/${this.uri}`)
                .then(({ data }) => {
                    this.report = data.report;
                    this.assignees = data.assignees;
                    NProgress.inc();
                })
                .catch(() => {
                    this.$router.push({ name: 'reports' });
                });
        },

        inputDetailOption(data) {
            this.report.incident_detail_option = data.slug;
        },

        async saveReport() {
            this.errors = [];

            await this.request()
                .post(`/api/reports/${this.report.id}`, this.report)
                .then(({ data }) => {
                    this.report = data.report;
                    this.assignees = data.assignees;
                    this.$store.dispatch('search/buildIndex', true);
                    this.$toasted.show(this.trans.saved, {
                        className: 'bg-success',
                    });
                })
                .catch((error) => {
                    this.errors = error.response.data.errors;
                });

            if (isEmpty(this.errors) && this.creatingReport) {
                await this.$router.push({ name: 'edit-report', params: { id: this.report.id } });
                NProgress.done();
            }
        },

        async deleteReport() {
            await this.request()
                .delete(`/api/reports/${this.report.id}`)
                .then(() => {
                    this.$store.dispatch('search/buildIndex', true);
                    this.$toasted.show(this.trans.success, {
                        className: 'bg-success',
                    });
                });

            $(this.$refs.deleteModal.$el).modal('hide');

            await this.$router.push({ name: 'reports' });
        },

        showDeleteModal() {
            $(this.$refs.deleteModal.$el).modal('show');
        },
    },
};
</script>
