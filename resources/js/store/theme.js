export default {
    state: {
        theme: {}
    },
    getters: {
        getTheme: (state) => {
            return state.theme;
        }
    },
    mutations: {
        SET_THEME(state, theme) {
            state.theme = theme;
            localStorage.theme = theme;
        }
    },
    actions: {
        initTheme({ commit }) {
            const cachedTheme = localStorage.theme ? localStorage.theme : false;
            if (cachedTheme)
                commit('SET_THEME', cachedTheme)
            else
                commit('SET_THEME', 'light')
        },
        toggleTheme({ commit }) {
            const html = document.querySelector("html");
            switch (localStorage.theme) {
                case 'light':
                    commit('SET_THEME', 'dark')
                    html.classList.remove("dark")
                    break;
                default:
                    html.classList.add("dark")
                    commit('SET_THEME', 'light')
                    break;
            }
        }
    },
}
