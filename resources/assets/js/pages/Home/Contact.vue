<template>
    <section
        id="contacts"
        class="wrapper"
    >
        <div class="left">
            <div class="top bg-main3">
                <img src="/images/logo.png" alt="OASYS">
                <article v-html="displayData.address && displayData.address.description" />
            </div>
            <div class="bottom">
                <article class="bg-main3">
                    <div class="color-main5" v-if="displayData.tel">
                        <img src="/images/icons/contact.png" alt="Telephone Number">
                        <a :href="`tel:${displayData.tel.description}`" class="color-main3">
                            {{ displayData.tel.description }}
                        </a>
                    </div>
                    <div class="color-main5" v-if="data.email">
                        <img src="/images/icons/email.png" alt="E-Mail">
                        <a :href="`mailto:${displayData.email.description}`" class="color-main3">
                            {{ displayData.email.description }}
                        </a>
                    </div>
                    <br>
                    <div class="color-main5" v-if="displayData.facebook">
                        <img src="/images/icons/fb.png" alt="Facebook">
                        <a :href="displayData.facebook.path" target="_blank" class="color-main3">
                            {{ displayData.facebook.description }}
                        </a>
                    </div>
                </article>
            </div>
        </div>
        <div class="right">
            <iframe
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3777.0562814104683!2d98.95062331482494!3d18.795644987249315!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x30da3a6e0d8891c9%3A0x2c728e2876b2505c!2z4LiE4LiT4Liw4Lin4Li04Lio4Lin4LiB4Lij4Lij4Lih4Lio4Liy4Liq4LiV4Lij4LmMIOC4oeC4q-C4suC4p-C4tOC4l-C4ouC4suC4peC4seC4ouC5gOC4iuC4teC4ouC4h-C5g-C4q-C4oeC5iA!5e0!3m2!1sth!2sth!4v1541856220308"
                width="100%"
                height="100%"
                frameborder="0"
                style="border:0"
                allowfullscreen
            />
        </div>
    </section>
</template>

<script>
import axios from 'axios'
export default {
    data() {
        return {
            data: {
                address: null,
                email: null,
                tel: null,
                facebook: null,
            }
        }
    },
    computed: {
        displayData() {
            return Object.keys(this.data).reduce((obj, dataKey) => {
                if (this.data[dataKey]) {
                    obj[dataKey] = this.data[dataKey]
                    obj[dataKey].description = this._i18n.locale === 'th' ? this.data[dataKey].th_description : this.data[dataKey].en_description
                }
                return obj
            }, {})
        }
    },
    mounted() {
        axios.get('/api/contact')
            .then(response => response.data)
            .then(responseBody => {
                responseBody.data.forEach(data => {
                    this.data[data.keyword] = data
                })
            })
    }
}
</script>

<style lang="scss" scoped>
@import '../../../sass/responsive.scss';
.wrapper {
    display: flex;
    flex-direction: row;
    @include respond-to($tablet-portrait) {
        flex-direction: column;
    }
    & a {
        transition: 0.3s;
        text-decoration: none;
        &:hover {
            color: currentColor;
        }
    }
    & > .left {
        flex: 1;
        & > .top {
            padding: 24px 56px;
            padding-bottom: 0;
            @include respond-to($tablet-portrait) {
                padding-left: 4%;
                padding-right: 4%;
            }
            & > img {
                width: 100%;
                max-width: 320px;
                margin-top: 36px;
                margin-bottom: 24px;
            }
            & > article {
                padding: 24px;
                background-color: #FFF;
                border-top-left-radius: 4px;
                border-top-right-radius: 4px;
            }
        }
        & > .bottom {
            padding: 36px 56px;
            padding-top: 0;
            @include respond-to($tablet-portrait) {
                padding-left: 4%;
                padding-right: 4%;
            }
            background-color: #FFF;
            & > article {
                border-bottom-left-radius: 4px;
                border-bottom-right-radius: 4px;
                padding: 24px;
                color: #FFF;
                & > div {
                    & > img {
                        width: 14px;
                        margin-right: 8px;
                    }
                    display: flex;
                    flex-direction: row;
                    align-items: center;
                }
            }
        }
    }
    & > .right {
        flex: 1;
        & > iframe {
            min-height: 360px;
        }
    }
}
</style>