import "./bootstrap";
import "../css/app.css";

import { createApp, h } from "vue";
import { createInertiaApp, Link, Head } from "@inertiajs/inertia-vue3";
import { InertiaProgress } from "@inertiajs/progress";
import { resolvePageComponent } from "laravel-vite-plugin/inertia-helpers";
import { ZiggyVue } from "../../vendor/tightenco/ziggy/dist/vue.m";
import AOS from "aos";
import "aos/dist/aos.css";
import "@fortawesome/fontawesome-free/css/all.css";
import "@fortawesome/fontawesome-free/js/all.js";
import { createStore } from "vuex";
import VueSweetalert2 from "vue-sweetalert2";
import "sweetalert2/dist/sweetalert2.min.css";

import navbar from "./Pages/Layout/navbar.vue";
import ModalMd from "./Pages/Component/modal-md.vue";
import { Inertia } from "@inertiajs/inertia";

const appName =
    window.document.getElementsByTagName("title")[0]?.innerText || "Toko Racun";

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) =>
        resolvePageComponent(
            `./Pages/${name}.vue`,
            import.meta.glob("./Pages/**/*.vue")
        ),
    setup({ el, app, props, plugin }) {
        return createApp({ render: () => h(app, props) })
            .use(plugin)
            .use(store)
            .use(ZiggyVue, Ziggy)
            .use(AOS.init())
            .use(VueSweetalert2)
            .component("Navbar", navbar)
            .component("Head", Head)
            .component("modal-md", ModalMd)
            .component("Link", Link)
            .mixin({
                props: {
                    user: Object,
                    cari: String,
                    show: Number,
                    range: Array,
                },
                data() {
                    return {
                        success: null,
                        input_cari: this.cari,
                        input_show: this.show,
                        input_range: {
                            dari: this.range ? this.range["dari"] : null,
                            sampai: this.range ? this.range["sampai"] : null,
                        },
                    };
                },
                methods: {
                    rupiah(data) {
                        return new Intl.NumberFormat("id-ID", {
                            style: "currency",
                            currency: "IDR",
                            maximumFractionDigits: 0,
                        }).format(data);
                    },
                    get_data() {
                        Inertia.get(
                            route("produk.index", {
                                cari: this.input_cari,
                                show: this.input_show,
                            }),
                            {
                                preserveScroll: true,
                            }
                        );
                    },
                    get_transaksi() {
                        Inertia.get(
                            route("transaksi.index", {
                                cari: this.input_cari,
                                show: this.input_show,
                                range: this.input_range,
                            }),
                            {
                                preserveScroll: true,
                            }
                        );
                    },
                    close_modal(data) {
                        document.getElementById(data).click();
                    },
                    notifikasi(data) {
                        this.success = data;
                        setTimeout(() => {
                            this.success = null;
                        }, 3000);
                    },
                    terbilang_rupiah(value) {
                        function terbilang(a) {
                            var c =
                                " Satu Dua Tiga Empat Lima Enam Tujuh Delapan Sembilan Sepuluh Sebelas".split(
                                    " "
                                );
                            if (12 > a) var b = c[a];
                            else
                                20 > a
                                    ? (b = c[a - 10] + " Belas")
                                    : 100 > a
                                    ? ((b = parseInt(
                                          String(a / 10).substr(0, 1)
                                      )),
                                      (b = c[b] + " Puluh " + c[a % 10]))
                                    : 200 > a
                                    ? (b = "Seratus " + terbilang(a - 100))
                                    : 1e3 > a
                                    ? ((b = parseInt(
                                          String(a / 100).substr(0, 1)
                                      )),
                                      (b =
                                          c[b] +
                                          " Ratus " +
                                          terbilang(a % 100)))
                                    : 2e3 > a
                                    ? (b = "Seribu " + terbilang(a - 1e3))
                                    : 1e4 > a
                                    ? ((b = parseInt(
                                          String(a / 1e3).substr(0, 1)
                                      )),
                                      (b =
                                          c[b] + " Ribu " + terbilang(a % 1e3)))
                                    : 1e5 > a
                                    ? ((b = parseInt(
                                          String(a / 100).substr(0, 2)
                                      )),
                                      (a %= 1e3),
                                      (b =
                                          terbilang(b) +
                                          " Ribu " +
                                          terbilang(a)))
                                    : 1e6 > a
                                    ? ((b = parseInt(
                                          String(a / 1e3).substr(0, 3)
                                      )),
                                      (a %= 1e3),
                                      (b =
                                          terbilang(b) +
                                          " Ribu " +
                                          terbilang(a)))
                                    : 1e8 > a
                                    ? ((b = parseInt(
                                          String(a / 1e6).substr(0, 4)
                                      )),
                                      (a %= 1e6),
                                      (b =
                                          terbilang(b) +
                                          " Juta " +
                                          terbilang(a)))
                                    : 1e9 > a
                                    ? ((b = parseInt(
                                          String(a / 1e6).substr(0, 4)
                                      )),
                                      (a %= 1e6),
                                      (b =
                                          terbilang(b) +
                                          " Juta " +
                                          terbilang(a)))
                                    : 1e10 > a
                                    ? ((b = parseInt(
                                          String(a / 1e9).substr(0, 1)
                                      )),
                                      (a %= 1e9),
                                      (b =
                                          terbilang(b) +
                                          " Milyar " +
                                          terbilang(a)))
                                    : 1e11 > a
                                    ? ((b = parseInt(
                                          String(a / 1e9).substr(0, 2)
                                      )),
                                      (a %= 1e9),
                                      (b =
                                          terbilang(b) +
                                          " Milyar " +
                                          terbilang(a)))
                                    : 1e12 > a
                                    ? ((b = parseInt(
                                          String(a / 1e9).substr(0, 3)
                                      )),
                                      (a %= 1e9),
                                      (b =
                                          terbilang(b) +
                                          " Milyar " +
                                          terbilang(a)))
                                    : 1e13 > a
                                    ? ((b = parseInt(
                                          String(a / 1e10).substr(0, 1)
                                      )),
                                      (a %= 1e10),
                                      (b =
                                          terbilang(b) +
                                          " Triliun " +
                                          terbilang(a)))
                                    : 1e14 > a
                                    ? ((b = parseInt(
                                          String(a / 1e12).substr(0, 2)
                                      )),
                                      (a %= 1e12),
                                      (b =
                                          terbilang(b) +
                                          " Triliun " +
                                          terbilang(a)))
                                    : 1e15 > a
                                    ? ((b = parseInt(
                                          String(a / 1e12).substr(0, 3)
                                      )),
                                      (a %= 1e12),
                                      (b =
                                          terbilang(b) +
                                          " Triliun " +
                                          terbilang(a)))
                                    : 1e16 > a &&
                                      ((b = parseInt(
                                          String(a / 1e15).substr(0, 1)
                                      )),
                                      (a %= 1e15),
                                      (b =
                                          terbilang(b) +
                                          " Kuadriliun " +
                                          terbilang(a)));
                            a = b.split(" ");
                            c = [];
                            for (b = 0; b < a.length; b++)
                                "" != a[b] && c.push(a[b]);
                            return c.join(" ");
                        }
                        return terbilang(value);
                    },
                },
            })
            .mount(el);
    },
});

// InertiaProgress.init({ color: "#4B5563" });

const store = createStore({
    state() {
        return {
            profiles: {
                name: null,
                foto: null,
                email: null,
            },
        };
    },
    mutations: {
        profiles(state, data) {
            state.profiles.name = data.name;
            state.profiles.email = data.email;
            state.profiles.foto = data.foto;
        },
    },
});
