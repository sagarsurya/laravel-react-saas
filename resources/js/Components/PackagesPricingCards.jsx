import { usePage } from "@inertiajs/react";

export default function CreditPricingCards( { packages, features } ){
    const { csrf_token } = usePage().props;

    return (
        <section className="">
            <div className="py-8 px-4">
                <div className="text-center mb-8">
                    <h2 className="mb-4 text-4xl font-extrabold">
                        The more credits you choose the bigger savings you will make
                    </h2>
                </div>
                <div className="space-y-8 lg:grid lg:grid-cols-3 sm:gap-6 xl:gap-10 lg:space-y-0">
                    {packages.map((p) => (
                        <div key={p.id} className="flex flex-col align-stretch p-6 mz-auto lg:mx-0 max-w-lg text-center rounded-lg border shadow border-gray-600">
                            <h3 className="mb-4 text-2xl font-semibold">
                                {p.name}
                            </h3>
                            <div className="flex justify-center items-baseline my-8">
                                <span className="mr-2 text-5x1 font-extrabold">
                                    ${p.price}
                                </span>
                                <span className="text-2x1 dark:text-gray-400">
                                    /{p.credits} credits
                                </span>
                            </div>
                            <ul role="list" className="mb-8 space-y-4 text-left">
                                {features.map((feature) => (
                                    <li key={feature.id} className="flex items-center space-x-3">
                                        <span>{feature.name}</span>
                                    </li>
                                ))}
                            </ul>
                            <form action={route("credits.buy", p)} method="post" className="w-full">
                                <input type="hidden" id="" name="_token" value={csrf_token} autoComplete="off"></input>
                                <button className="bg-blue-600 hover:bg-blue-700 focus:ring-4 font-medium rounded-1g text-sm px-5 py-2.5 text-center text-white focus: ring-blue-900 w-full">
                                    Get Started
                                </button>
                            </form>
                        </div>
                    ))}
                </div>
            </div>

        </section>
    )
}