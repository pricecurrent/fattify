const Ziggy = {"url":"https:\/\/fattify-inertia.test","port":null,"defaults":{},"routes":{"api.daily-consumption":{"uri":"api\/daily-consumption","methods":["GET","HEAD"]},"diary":{"uri":"diary\/{date?}","methods":["GET","HEAD"]},"nutrition-diary-entries.calories.store":{"uri":"nutrition-diary-entries\/calories","methods":["POST"]},"nutrition-diary-entries.macronutrients.store":{"uri":"nutrition-diary-entries\/macronutrients","methods":["POST"]},"login":{"uri":"login","methods":["GET","HEAD"]}}};

if (typeof window !== 'undefined' && typeof window.Ziggy !== 'undefined') {
    Object.assign(Ziggy.routes, window.Ziggy.routes);
}

export { Ziggy };
