<template>
    <section
        id="projects"
        class="wrapper"
    >
        <header>
            <nav>
                <ul>
                    <li
                        v-for="(project, index) in displayProjects"
                        :key="index"
                        :class="{'active' : currentMenuIndex === index}"
                        @click="changeMenu(index)"
                    >
                        <div class="icon">
                            <img :src="`/images/icons/${currentMenuIndex === index ? project.icon_active : project.icon}`" alt="">
                        </div>
                        <div class="label bg-main2 color-main2">
                            {{ project.name }}
                        </div>
                    </li>
                </ul>
            </nav>
            <div class="title bg-main4 color-main6">
                <span class="color-main4">{{ $t('project.header') }}</span>
            </div>
        </header>
        <article v-if="displayProjects[currentMenuIndex]">
            <div class="left">
                <div class="image">
                    <div class="imgWrapper">
                        <img
                            :src="displayProjects[currentMenuIndex].images.path"
                            :alt="displayProjects[currentMenuIndex].images.name"
                        >
                        <div class="overlay filter" />
                    </div>
                </div>
                <div class="title">
                    {{ displayProjects[currentMenuIndex].name }}
                </div>
            </div>
            <div class="right">
                <div class="title">
                    {{ displayProjects[currentMenuIndex].name }}
                </div>
                <div class="description">
                    <p v-html="displayProjects[currentMenuIndex].description" />
                    <!-- <a class="color-main5">See all project >>></a> -->
                </div>
                <div class="list" v-if="displayProjects[currentMenuIndex].subprojects.length > 0">
                    <carousel
                        :nav="false"
                        :dots="false"
                        :responsive="silderResponsive"
                        v-for="(project, index) in displayProjects"
                        :key="index"
                        v-if="currentMenuIndex === index"
                    >
                        <div
                            class="project"
                            v-for="(subproject, index) in displayProjects[currentMenuIndex].subprojects"
                            :key="index"
                            @click="openLink(subproject.external_path)"
                        >
                            <div class="imgWrapper">
                                <img
                                    :src="subproject.images.path"
                                    :alt="subproject.images.name"
                                >
                                <div class="overlay filter" />
                            </div>
                            <div class="projectContent">
                                <strong>{{ subproject.name }}</strong>
                                <br>
                                <span v-html="subproject.description"></span>
                            </div>
                        </div>

                        <template slot="prev">
                            <div class="leftButton">
                                <img src="/images/icons/arrow-left.png" alt="Previous">
                            </div>
                        </template>
                        <template slot="next">
                            <div class="rightButton">
                                <img src="/images/icons/arrow-right.png" alt="Next">
                            </div>
                        </template>
                    </carousel>
                </div>
            </div>
        </article>
    </section>
</template>

<script>
import carousel from '../../components/v-owl-carosuel'
export default {
    components: {
        carousel
    },
    data() {
        return {
            currentMenuIndex: 0,
            projects: []
        }
    },
    computed: {
        silderResponsive() {
            let newStep = 0
            return [...Array(24)].reduce((sum, each, index) => {
                const value = index * 450 + 700
                sum[value] = { items: index + 1 }
                return sum
            }, {
                0: {items: 1},
                670: {items: 2},
            })
        },
        displayProjects() {
            return this.projects.map(project => {
                return {
                    ...project,
                    name: this._i18n.locale === 'th' ? project.th_name : project.en_name,
                    description: this._i18n.locale === 'th' ? project.th_description : project.en_description,
                    subprojects: project.subprojects.map(subproject => ({
                        ...subproject,
                        name: this._i18n.locale === 'th' ? subproject.th_name : subproject.en_name,
                        description: this._i18n.locale === 'th' ? subproject.th_description : subproject.en_description,
                    }))
                }
            })
        }
    },
    mounted() {
        axios.get('/api/projects')
            .then(response => response.data)
            .then(responseBody => {
                const projects = responseBody.data.sort((memberA, memberB) => memberA.order_no - memberB.order_no)
                this.projects = projects
            })
    },
    methods: {
        changeMenu(index) {
            this.currentMenuIndex = index
        },
        openLink(url) {
            window.open(url, '_blank')
        }
    }
}
</script>

<style lang="scss" scoped>
@import '../../../sass/responsive.scss';

.wrapper {
    & > header {
        display: flex;
        flex-direction: row;
        justify-content: space-between;
        & {
            @include respond-to($mobile) {
                flex-direction: column-reverse;
            }
        }
        & > nav {
            flex: 1;
            margin-right: 8vw;
            & {
                @include respond-to($mobile) {
                    margin-right: 0;
                    margin-top: 6vw;
                }
            }
            & > ul {
                margin: 0 4vw;
                padding: 0;
                display: grid;
                grid-template-columns: auto auto auto auto;
                & {
                    @include respond-to($mobile) {
                        margin-top: 24px;
                        grid-template-columns: auto auto auto auto;
                        grid-row-gap: 24px;
                        grid-column-gap: 0;
                    }
                }
                list-style: none;
                & > li {
                    flex: 1;
                    text-align: center;
                    margin: 0 12px;
                    transition: 0.3s;
                    display: flex;
                    flex-direction: column;
                    justify-content: space-between;
                    cursor: pointer;
                    &:first-child {
                        margin-left: 0;
                    }
                    &:last-child {
                        margin-right: 0;
                    }
                    &:hover {
                        border-radius: 8px;
                        box-shadow: 0 0 24px rgb(180, 147, 147);
                        background-color: #FFF;
                    }
                    &.active {
                        border-radius: 8px;
                        box-shadow: 0 0 24px #CCC;
                        background-color: #FFF;
                    }
                    & > .icon {
                        padding: 24px;
                        & {
                            @include respond-to($mobile) {
                                padding: 12px;
                            }
                        }
                        & > img {
                            height: 48px;
                            & {
                                @include respond-to($mobile) {
                                    height: 32px;
                                }
                            }
                        }
                    }
                    &:not(.active) > .label{
                        background-color: #FFF;
                        padding: 4px 12px;
                        border-bottom-left-radius: 8px;
                        border-bottom-right-radius: 8px;
                        & {
                            @include respond-to($mobile) {
                                display: none;
                            }
                        }
                    }
                    &.active > .label {
                        padding: 4px 12px;
                        border-bottom-left-radius: 8px;
                        border-bottom-right-radius: 8px;
                        & {
                            @include respond-to($mobile) {
                                display: none;
                            }
                        }
                    }
                }
            }
        }
        & > .title {
            padding: 12px 48px;
            font-weight: 900;
            font-size: 3em;
            border-bottom-left-radius: 4px;
            height: 100%;
            position: relative;
            & {
                @include respond-to($mobile) {
                    margin-left: 10vw;
                    font-size: 2em;
                    padding: 12px 45px;
                }
            }
            &::after {
                content: '';
                display: block;
                position: absolute;
                width: 100%;
                padding-left: 36px;
                height: 64px;
                z-index: -1;
                background-color: currentColor;
                left: -36px;
                bottom: -36px;
                box-sizing: content-box;
            }
        }
    }
    & > article {
        margin-top: 24px;
        display: flex;
        flex-direction: row;
        & > .left {
            flex: 2;
            display: flex;
            flex-direction: column;
            & {
                @include respond-to($mobile) {
                    display: none;
                }
            }
            & > .image {
                flex: 1;
                align-items: center;
                min-height: 400px;
                max-height: 400px;
                display: flex;
                & > .imgWrapper > img {
                    // height: 100%;
                    width: 100%;
                    // height: inherit;
                    // object-fit: cover;
                }
            }
            & > .title {
                text-align: center;
                font-size: 2em;
                font-weight: 500;
                padding: 50px 0 70px 0;
            }
        }
        & > .right {
            flex: 5;
            margin-left: 24px;
            overflow-x: hidden;
            & {
                @include respond-to($mobile) {
                    margin-left: 0;
                    margin-bottom: 24px;
                }
            }
            & > .title {
                display: none;
                text-align: center;
                font-weight: 500;
                font-size: 2em;
                margin-bottom: 24px;
                & {
                    @include respond-to($mobile) {
                        display: inherit;
                    }
                }
            }
            & > .description {
                padding: 64px 64px 10px 64px;
                font-size: 1rem;
                & {
                    @include respond-to($mobile) {
                        padding: 10px 35px 0px 35px;
                        font-size: 14px;
                    }
                }
                & > a {
                    font-weight: 500;
                }
            }
            & > .list {
                position: relative;
                margin: 0 64px;
                & {
                    @include respond-to($mobile) {
                        margin: 0 55px;
                    }
                }
                a{
                    color:inherit;
                }
                & .project {
                    cursor: pointer;
                    background-color: #FFF;
                    border-radius: 8px;
                    margin: 12px;
                    margin-bottom: 36px;
                    box-shadow: 0 0 10px #AAA;
                    & > .imgWrapper {
                        width: 100%;
                        height: 200px;
                        border-top-left-radius: 8px;
                        border-top-right-radius: 8px;
                        & {
                            @include respond-to($mobile) {
                                height: 150px;
                            }
                        }
                        & > img {
                            width: 100%;
                            height: 100%;
                            object-fit: cover;
                            border-top-left-radius: 8px;
                            border-top-right-radius: 8px;
                        }
                        & > .overlay {
                            border-top-left-radius: 8px;
                            border-top-right-radius: 8px;
                        }
                    }
                    & > .projectContent {
                        padding: 24px;
                    }
                }
                %navigateButton {
                    position: absolute;
                    bottom: 0;
                    opacity: 0.8;
                    cursor: pointer;
                    transition: 0.3s;
                    z-index: 100;
                    &:hover {
                        opacity: 1;
                    }
                    & > img {
                        width: 36px;
                        height: 36px;
                    }
                }
                & .leftButton {
                    @extend %navigateButton;
                    left: -48px;
                    top: 50%;
                    margin-top: -13px;
                }
                & .rightButton {
                    @extend %navigateButton;
                    right: -48px;
                    top: 50%;
                    margin-top: -13px;
                }
            }
        }
    }
}

.imgWrapper {
    position: relative;
}

.overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    z-index: 50;
}
</style>

