import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";
import { Head } from "@inertiajs/react";
import PackagesPricingCards from "@/Components/PackagesPricingCards";

export default function Index({ auth, packages, features, success, error }) {
    const availableCredits = auth.user.available_credits;

    return (
        <AuthenticatedLayout
            user={auth.user}
            header={
                <h2 className="font-semibold text-xl text-grey-800 leading-tight">
                    Your Credits
                </h2>
            }
        >

            <Head title="Your Credits" />
            <div className="py-2">
                <div className="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    {success && <div className="rounded-lg bg-emrald-500 text-gray-100 p-3 mb-4">
                        {success}
                    </div>}
                    {error && <div className="rounded-lg bg-emrald-500 text-gray-100 p-3 mb-4">
                        {error}
                    </div>}
                    <div className="bg-white overflow-hidden shadow-sm sm:rounded-lg relative">
                        <div className="flex flex-col gap-3 items-center p-4">
                            <img src='/laravel-react-saas/public/img/coin.png' className="w-[100px]" alt="" />
                            <h3 className="text-2xl">
                                You have {availableCredits} credits.
                            </h3>
                        </div>
                    </div>
                    <PackagesPricingCards packages={packages.data} features={features.data} />
                </div>

            </div>




        </AuthenticatedLayout>
    )
}