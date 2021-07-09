<template>
    <section>
        <scrollactive
            class="wrapper"
            :offset="100"
        >
            <div class="desktop">
                <div class="left">
                    <ul class="menu">
                        <li>
                            <img
                                class="logo"
                                src="/images/logo.png"
                                alt="Oasys"
                            >
                        </li>
                        <li
                            v-for="(menu, index) in currentMenus.filter(menu => menu.localeString !== 'navbar.contacts')"
                            :key="index"
                            class="color-main5"
                        >
                            <a
                                v-if="menu.section"
                                class="scrollactive-item"
                                :href="menu.section.tag"
                            >
                                {{ $t(menu.localeString) }}
                            </a>
                            <a
                                v-else
                                :href="menu.path"
                                :class="{'is-active' : currentPath === menu.path}"
                            >
                                {{ $t(menu.localeString) }}
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="right">
                    <ul class="menu">
                        <li
                            v-for="(menu, index) in currentMenus.filter(menu => menu.localeString === 'navbar.contacts')"
                            :key="index"
                            class="color-main5"
                        >
                            <a
                                v-if="menu.section"
                                class="scrollactive-item"
                                :href="menu.section.tag"
                            >
                                {{ $t(menu.localeString) }}
                            </a>
                            <a
                                v-else
                                :href="menu.path"
                                :class="{'is-active' : currentPath === menu.path}"
                            >
                                {{ $t(menu.localeString) }}
                            </a>
                        </li>
                        <li class="color-main5">
                            <a
                                href="#"
                                class="changeLanguage"
                                @click="toggleLanguage('desktop')"
                            >
                                {{ currentLanguage }}
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="mobile">
                <svg id="hamburger" class="hamburger color-main5">
                    <path d="M4,10h24c1.104,0,2-0.896,2-2s-0.896-2-2-2H4C2.896,6,2,6.896,2,8S2.896,10,4,10z M28,14H4c-1.104,0-2,0.896-2,2  s0.896,2,2,2h24c1.104,0,2-0.896,2-2S29.104,14,28,14z M28,22H4c-1.104,0-2,0.896-2,2s0.896,2,2,2h24c1.104,0,2-0.896,2-2  S29.104,22,28,22z" />
                </svg>
                <img
                    class="logo"
                    src="/images/logo.png"
                    alt="Oasys"
                >
            </div>
        </scrollactive>
        <scrollactive
            id="mobile-menu"
            :offset="100"
        >
            <ul class="menu">
                <li
                    v-for="(menu, index) in currentMenus"
                    :key="index"
                    class="color-main5"
                >
                    <a
                        v-if="menu.section"
                        class="scrollactive-item"
                        :href="menu.section.tag"
                        @click="closeMobileMenu"
                    >
                        {{ $t(menu.localeString) }}
                    </a>
                    <a
                        v-else
                        :href="menu.path"
                        :class="{'is-active' : currentPath === menu.path}"
                        @click="closeMobileMenu"
                    >
                        {{ $t(menu.localeString) }}
                    </a>
                </li>
                <li class="color-main5">
                    <a
                        href="#"
                        class="changeLanguage"
                        @click="toggleLanguage('mobile')"
                    >
                        {{ currentLanguage }}
                    </a>
                </li>
            </ul>
        </scrollactive>
    </section>
</template>

<script>
export default {
    data() {
        return {
            currentLanguage: localStorage.getItem('locale') || 'th',
            currentPath: window.location.pathname,
            menus: [
                {
                    localeString: 'navbar.home',
                    path: '/',
                    sections: [
                        {
                            tag: '#banner',
                            path: '/'
                        }
                    ]
                },
                {
                    localeString: 'navbar.about',
                    path: '/#about',
                    sections: [
                        {
                            tag: '#about',
                            path: '/'
                        }
                    ]
                },
                {
                    localeString: 'navbar.projects',
                    path: '/#projects',
                    sections: [
                        {
                            tag: '#projects',
                            path: '/'
                        }
                    ]
                },
                {
                    localeString: 'navbar.articles',
                    path: '/#articles',
                    sections: [
                        {
                            tag: '#articles',
                            path: '/'
                        }
                    ]
                },
                {
                    localeString: 'navbar.members',
                    path: '/#members',
                    sections: [
                        {
                            tag: '#members',
                            path: '/'
                        }
                    ]
                },
                {
                    localeString: 'navbar.publications',
                    path: '/publications',
                    sections: []
                },
                {
                    localeString: 'navbar.contacts',
                    path: '/#contacts',
                    sections: [
                        {
                            tag: '#contacts',
                            path: '/'
                        }
                    ]
                },
            ]
        }
    },
    computed: {
        currentMenus() {
            return this.menus.map(menu => {
                return {
                    ...menu,
                    section: menu.sections.find(section => section.path === this.currentPath)
                }
            })
        }
    },
    methods: {
        toggleLanguage(mode) {
            if (mode === 'mobile') {
                this.closeMobileMenu()
            }
            if (this.currentLanguage === 'en') {
                this.changeLanguage('th')
            }
            else if (this.currentLanguage === 'th') {
                this.changeLanguage('en')
            }
        },
        changeLanguage(language) {
            this._i18n.locale = language
            this.currentLanguage = language
            localStorage.setItem('locale', language)
        },
        closeMobileMenu() {
            this.$parent.slideout.close()
        }
    }
}
</script>


<style lang="scss" scoped>
@import '../../sass/responsive.scss';
$mobile-max-width: 1024px;
.wrapper {
    padding: 24px 48px;
    background: linear-gradient(to bottom, rgba(0, 0, 0, 0.9), rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0));
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    color: #FFF;
    font-weight: 500;
    z-index: 1000;
    & {
        @include respond-to($mobile) {
            padding: 24px;
        }
    }
    & a {
        transition: 0.3s;
        text-decoration: none;
        &:link, &:visited {
            color: #FFF;
        }
        &:hover {
            color: currentColor;
        }
        &.is-active {
            color: currentColor;
            font-weight: bold;
        }
    }

    & img.logo {
        height: 20px;
    }

    & ul.menu {
        list-style: none;
        margin: 0;
        padding: 0;
        display: flex;
        flex-direction: row;
        & > li {
            margin: 0 24px;
        }
    }

    & > .desktop {
        display: flex;
        flex-direction: row;
        align-items: center;
        justify-content: space-between;
        & {
            @include respond-to((max-width: $mobile-max-width)) {
                display: none;
            }
        }

        & > .right {
            & a.changeLanguage {
                border: 1px solid #FFF;
                padding: 8px;
                border-radius: 4px;
                text-transform: uppercase;
                transition: 0.3s;
                &:hover {
                    color: currentColor;
                    border-color: currentColor;
                }
            }
        }
    }

    & > .mobile {
        & {
            @include respond-to((min-width: $mobile-max-width)) {
                display: none;
            }
        }
        & svg.hamburger {
            margin-top: -4px;
            margin-right: 12px;
            width: 32px;
            height: 32px;
            cursor: pointer;
            & > path {
                transition: 0.3s;
                fill: #FFF;
            }
            &:hover {
                & > path {
                    fill: currentColor;
                }
            }
        }
    }
}
#mobile-menu {
    color: #FFF;
    & a {
        color: #FFF;
        transition: 0.3s;
        text-decoration: none;
        &:hover {
            color: currentColor;
        }
        &.is-active {
            color: currentColor;
            font-weight: bold;
        }
    }
    & a.changeLanguage {
        border: 1px solid #FFF;
        padding: 8px;
        border-radius: 4px;
        text-transform: uppercase;
        margin-top: 12px;
        &:hover {
            color: currentColor;
            border-color: currentColor;
        }
    }
    & > ul {
        list-style: none;
        margin: 0;
        margin-top: 64px;
        padding: 0;
        & > li {
            padding: 12px 24px;
            border-bottom: 1px solid #333;
            &:last-child {
                border-bottom: 0;
                padding: 24px;
            }
        }
    }
}
</style>
