import request from '../../mixins/request';

const initialState = {
    i18n: window.Dashboard.translations,
    languageCodes: window.Dashboard.languageCodes,
    maxUpload: window.Dashboard.maxUpload,
    path: window.Dashboard.path,
    timezone: window.Dashboard.timezone,
    unsplash: window.Dashboard.unsplash,
    user: window.Dashboard.user,
    roles: window.Dashboard.roles,
};

const state = { ...initialState };

const actions = {
    updateDigest(context, payload) {
        request.methods
            .request()
            .post(`/api/users/${state.user.id}`, {
                name: state.user.name,
                email: state.user.email,
                digest: payload,
            })
            .then(({ data }) => {
                context.commit('UPDATE_DIGEST', data.user);
            });
    },

    updateLocale(context, payload) {
        request.methods
            .request()
            .post(`/api/users/${state.user.id}`, {
                name: state.user.name,
                email: state.user.email,
                locale: payload,
            })
            .then(({ data }) => {
                context.commit('UPDATE_LOCALE', data);
            });
    },

    updateDarkMode(context, payload) {
        request.methods
            .request()
            .post(`/api/users/${state.user.id}`, {
                name: state.user.name,
                email: state.user.email,
                dark_mode: payload,
            })
            .then(({ data }) => {
                context.commit('UPDATE_DARK_MODE', data.user);
            });
    },

    setUser(context, user) {
        context.commit('SET_USER', user);
    },
};

const mutations = {
    UPDATE_DIGEST(state, user) {
        state.user.digest = user.digest;
    },

    UPDATE_LOCALE(state, data) {
        state.i18n = data.i18n;
        state.user.locale = data.user.locale;
    },

    UPDATE_DARK_MODE(state, user) {
        state.user.dark_mode = user.dark_mode;
    },

    SET_USER(state, user) {
        state.user = user;
    },
};

const getters = {
    trans(state) {
        return JSON.parse(state.i18n);
    },

    isContributor(state) {
        return state.user.role === 1;
    },

    isEditor(state) {
        return state.user.role === 2;
    },

    isAdmin(state) {
        return state.user.role === 3;
    },
    user(state) {
        return state.user;
    },
};

export default {
    namespaced: true,
    state,
    actions,
    mutations,
    getters,
};
