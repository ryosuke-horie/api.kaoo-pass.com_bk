<script setup>
import { ref } from "vue";
import { router, useForm } from "@inertiajs/vue3";

import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import Input from "@/Components/organisms/Input.vue";
import FileInput from "@/Components/organisms/FileInput.vue";

/**
 * 会員登録フォーム
 *
 * @see https://preline.co/examples/application-form-layouts.html
 */
defineProps({
    user: {
        type: Object,
        required: true,
    },
});

/**
 * インプット要素の値を定義
 */
const lastName = ref("");
const firstName = ref("");
const email = ref("");
const phone = ref("");
const address = ref("");
const memo = ref("");

const form = useForm({
    file1: "",
    file2: "",
    file3: "",
});

/**
 * 会員情報送信処理
 */
const submit = () => {
    // FormDataオブジェクトの作成
    const formData = new FormData();

    // テキストフィールドのデータをFormDataに追加
    formData.append("last_name", lastName.value);
    formData.append("first_name", firstName.value);
    formData.append("email", email.value);
    formData.append("phone", phone.value);
    formData.append("address", address.value);
    formData.append("memo", memo.value);

    // ファイルデータが存在する場合、FormDataに追加
    if (form.file1) formData.append("file1", form.file1);
    if (form.file2) formData.append("file2", form.file2);
    if (form.file3) formData.append("file3", form.file3);

    // Inertia.jsを使ってFormDataを含む会員情報を登録
    router.post("/members/store", formData, {
        forceFormData: true,
    });
};
</script>

<template>
    <AuthenticatedLayout :user="user">
        <!-- Card Section -->
        <div class="max-w-4xl px-4 py-10 sm:px-6 lg:px-8 lg:py-14 mx-auto">
            <!-- Card -->
            <div
                class="bg-white rounded-xl shadow p-4 sm:p-7 dark:bg-slate-900"
            >
                <form>
                    <!-- Section｜プロフィール -->
                    <div
                        class="grid sm:grid-cols-12 gap-2 sm:gap-4 py-8 first:pt-0 last:pb-0 border-t first:border-transparent border-gray-200 dark:border-gray-700 dark:first:border-transparent"
                    >
                        <div class="sm:col-span-12">
                            <h2
                                class="text-lg font-semibold text-gray-800 dark:text-gray-200"
                            >
                                プロフィール
                            </h2>
                        </div>
                        <!-- End Col -->

                        <!-- Note：分割したInputはコンポーネント未対応 -->
                        <div class="sm:col-span-3">
                            <label
                                for="af-submit-application-full-name"
                                class="inline-block text-sm font-medium text-gray-500 mt-2.5"
                            >
                                苗字 | 名前
                                <span class="text-red-500">*</span>
                            </label>
                        </div>

                        <div class="sm:col-span-9">
                            <div class="sm:flex">
                                <input
                                    id="af-submit-application-full-name"
                                    type="text"
                                    v-model="lastName"
                                    class="py-2 px-3 pe-11 block w-full border-gray-200 shadow-sm -mt-px -ms-px first:rounded-t-lg last:rounded-b-lg sm:first:rounded-s-lg sm:mt-0 sm:first:ms-0 sm:first:rounded-se-none sm:last:rounded-es-none sm:last:rounded-e-lg text-sm relative focus:z-10 focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400 dark:focus:ring-gray-600"
                                />
                                <input
                                    type="text"
                                    v-model="firstName"
                                    class="py-2 px-3 pe-11 block w-full border-gray-200 shadow-sm -mt-px -ms-px first:rounded-t-lg last:rounded-b-lg sm:first:rounded-s-lg sm:mt-0 sm:first:ms-0 sm:first:rounded-se-none sm:last:rounded-es-none sm:last:rounded-e-lg text-sm relative focus:z-10 focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400 dark:focus:ring-gray-600"
                                />
                            </div>
                        </div>

                        <Input
                            label="メールアドレス"
                            id="email"
                            v-model="email"
                            required
                        />
                        <Input
                            label="電話番号"
                            id="phone"
                            v-model="phone"
                            required
                        />
                        <Input
                            label="住所"
                            id="address"
                            v-model="address"
                            required
                        />
                    </div>
                    <!-- End Section -->

                    <!-- Section|顔写真 -->
                    <div
                        class="grid sm:grid-cols-12 gap-2 sm:gap-4 py-8 first:pt-0 last:pb-0 border-t first:border-transparent border-gray-200 dark:border-gray-700 dark:first:border-transparent"
                    >
                        <div class="sm:col-span-12">
                            <h2
                                class="text-lg font-semibold text-gray-800 dark:text-gray-200"
                            >
                                顔写真
                            </h2>
                        </div>
                        <!-- End Col -->

                        <FileInput
                            label="1枚目"
                            id="file1"
                            @file-selected="(file) => (form.file1 = file)"
                            required
                        />

                        <FileInput
                            label="2枚目"
                            id="file2"
                            @file-selected="(file) => (form.file2 = file)"
                            required
                        />

                        <FileInput
                            label="3枚目"
                            id="file3"
                            @file-selected="(file) => (form.file3 = file)"
                            required
                        />
                    </div>
                    <!-- End Section -->

                    <!-- Section｜メモ -->
                    <div
                        class="grid sm:grid-cols-12 gap-2 sm:gap-4 py-8 first:pt-0 last:pb-0 border-t first:border-transparent border-gray-200 dark:border-gray-700 dark:first:border-transparent"
                    >
                        <div class="sm:col-span-12">
                            <h2
                                class="text-lg font-semibold text-gray-800 dark:text-gray-200"
                            >
                                メモ
                            </h2>
                        </div>

                        <div class="sm:col-span-12">
                            <textarea
                                id="af-submit-application-bio"
                                class="py-2 px-3 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400 dark:focus:ring-gray-600"
                                rows="6"
                                placeholder="メモ・備考などがあればこちらに入力してください。"
                                v-model="memo"
                            ></textarea>
                        </div>
                    </div>
                    <!-- End Section -->

                    <button
                        type="button"
                        @click="submit"
                        class="w-full py-3 px-4 inline-flex justify-center items-center gap-x-2 text-sm font-semibold rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600"
                    >
                        送信
                    </button>
                </form>
            </div>
            <!-- End Card -->
        </div>
        <!-- End Card Section -->
    </AuthenticatedLayout>
</template>
