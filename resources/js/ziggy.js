const Ziggy = {
    "url": "http:\/\/port.test", "port": null, "defaults": {}, "routes": {
        "debugbar.openhandler": {"uri": "_debugbar\/open", "methods": ["GET", "HEAD"]},
        "debugbar.clockwork": {"uri": "_debugbar\/clockwork\/{id}", "methods": ["GET", "HEAD"]},
        "debugbar.telescope": {"uri": "_debugbar\/telescope\/{id}", "methods": ["GET", "HEAD"]},
        "debugbar.assets.css": {"uri": "_debugbar\/assets\/stylesheets", "methods": ["GET", "HEAD"]},
        "debugbar.assets.js": {"uri": "_debugbar\/assets\/javascript", "methods": ["GET", "HEAD"]},
        "debugbar.cache.delete": {"uri": "_debugbar\/cache\/{key}\/{tags?}", "methods": ["DELETE"]},
        "login": {"uri": "login", "methods": ["GET", "HEAD"]},
        "logout": {"uri": "logout", "methods": ["POST"]},
        "password.request": {"uri": "forgot-password", "methods": ["GET", "HEAD"]},
        "password.reset": {"uri": "reset-password\/{token}", "methods": ["GET", "HEAD"]},
        "password.email": {"uri": "forgot-password", "methods": ["POST"]},
        "password.update": {"uri": "reset-password", "methods": ["POST"]},
        "register": {"uri": "register", "methods": ["GET", "HEAD"]},
        "user-profile-information.update": {"uri": "user\/profile-information", "methods": ["PUT"]},
        "user-password.update": {"uri": "user\/password", "methods": ["PUT"]},
        "password.confirm": {"uri": "user\/confirm-password", "methods": ["GET", "HEAD"]},
        "password.confirmation": {"uri": "user\/confirmed-password-status", "methods": ["GET", "HEAD"]},
        "two-factor.login": {"uri": "two-factor-challenge", "methods": ["GET", "HEAD"]},
        "two-factor.enable": {"uri": "user\/two-factor-authentication", "methods": ["POST"]},
        "two-factor.disable": {"uri": "user\/two-factor-authentication", "methods": ["DELETE"]},
        "two-factor.qr-code": {"uri": "user\/two-factor-qr-code", "methods": ["GET", "HEAD"]},
        "two-factor.recovery-codes": {"uri": "user\/two-factor-recovery-codes", "methods": ["GET", "HEAD"]},
        "profile.show": {"uri": "user\/profile", "methods": ["GET", "HEAD"]},
        "other-browser-sessions.destroy": {"uri": "user\/other-browser-sessions", "methods": ["DELETE"]},
        "current-user-photo.destroy": {"uri": "user\/profile-photo", "methods": ["DELETE"]},
        "current-user.destroy": {"uri": "user", "methods": ["DELETE"]},
        "teams.create": {"uri": "teams\/create", "methods": ["GET", "HEAD"]},
        "teams.store": {"uri": "teams", "methods": ["POST"]},
        "teams.show": {"uri": "teams\/{team}", "methods": ["GET", "HEAD"]},
        "teams.update": {"uri": "teams\/{team}", "methods": ["PUT"]},
        "teams.destroy": {"uri": "teams\/{team}", "methods": ["DELETE"]},
        "current-team.update": {"uri": "current-team", "methods": ["PUT"]},
        "team-members.store": {"uri": "teams\/{team}\/members", "methods": ["POST"]},
        "team-members.update": {"uri": "teams\/{team}\/members\/{user}", "methods": ["PUT"]},
        "team-members.destroy": {"uri": "teams\/{team}\/members\/{user}", "methods": ["DELETE"]},
        "team-invitations.accept": {
            "uri": "team-invitations\/{invitation}",
            "methods": ["GET", "HEAD"],
            "bindings": {"invitation": "id"}
        },
        "team-invitations.destroy": {
            "uri": "team-invitations\/{invitation}",
            "methods": ["DELETE"],
            "bindings": {"invitation": "id"}
        },
        "caravan.price.calculate": {"uri": "caravan\/price\/calculate", "methods": ["POST"]},
        "dashboard": {"uri": "\/", "methods": ["GET", "HEAD"]},
        "caravans.index": {"uri": "caravans", "methods": ["GET", "HEAD"]},
        "caravans.create": {"uri": "caravans\/create", "methods": ["GET", "HEAD"]},
        "caravans.store": {"uri": "caravans", "methods": ["POST"]},
        "caravans.show": {"uri": "caravans\/{caravan}", "methods": ["GET", "HEAD"], "bindings": {"caravan": "id"}},
        "caravans.edit": {
            "uri": "caravans\/{caravan}\/edit",
            "methods": ["GET", "HEAD"],
            "bindings": {"caravan": "id"}
        },
        "caravans.update": {"uri": "caravans\/{caravan}", "methods": ["PUT", "PATCH"], "bindings": {"caravan": "id"}},
        "caravans.destroy": {"uri": "caravans\/{caravan}", "methods": ["DELETE"], "bindings": {"caravan": "id"}},
        "caravanDates.index": {"uri": "caravanDates", "methods": ["GET", "HEAD"]},
        "caravanDates.create": {"uri": "caravanDates\/create", "methods": ["GET", "HEAD"]},
        "caravanDates.store": {"uri": "caravanDates", "methods": ["POST"]},
        "caravanDates.show": {
            "uri": "caravanDates\/{caravanDate}",
            "methods": ["GET", "HEAD"],
            "bindings": {"caravanDate": "id"}
        },
        "caravanDates.edit": {
            "uri": "caravanDates\/{caravanDate}\/edit",
            "methods": ["GET", "HEAD"],
            "bindings": {"caravanDate": "id"}
        },
        "caravanDates.update": {
            "uri": "caravanDates\/{caravanDate}",
            "methods": ["PUT", "PATCH"],
            "bindings": {"caravanDate": "id"}
        },
        "caravanDates.destroy": {
            "uri": "caravanDates\/{caravanDate}",
            "methods": ["DELETE"],
            "bindings": {"caravanDate": "id"}
        }
    }
};

if (typeof window !== 'undefined' && typeof window.Ziggy !== 'undefined') {
    Object.assign(Ziggy.routes, window.Ziggy.routes);
}

export {Ziggy};
