
class NavbarV2 {
	init(routeSegments) {
        var currentRouteBase = null;
        routeSegments.shift();

        switch (routeSegments.length) {
            case 1:
                currentRouteBase = routeSegments[0];
                break;
            case 2:
                currentRouteBase = routeSegments.join('.');
                break;
            case 3:
                routeSegments.pop();
                currentRouteBase = routeSegments.join('.');
                break;
        }
//        console.info('routeSegments', routeSegments);
//        console.info('currentRouteBase', currentRouteBase);

        $('.btn-toggle').click(e => {
            let $current = $(e.target);
            $('li.parent','ul.nav').each((i,li) => {
                let $toggle = $(li).find('.btn-toggle'),
                    $collapse = $toggle.next('div'),
                    $target = $toggle.data('bs-target'),
                    $currentTarget = $current.data('bs-target');

                if($target === $currentTarget) {
//                    console.info('target', $target);

                    $($currentTarget).collapse('show');
                    $($currentTarget).find('.nav-link').each((i,a) => {
                        let $a = $(a),
                            route = $a.data('route') ?? null,
                            $li = $a.parent('li'),
                            $collapse = $li.parent('ul').parent('div');

//                        console.info('collapse routes', route);

                        if(currentRouteBase && route && route === currentRouteBase) {
//                            console.info('route', route);
                            $li.addClass('active')
                            $collapse.removeClass('collapse')
                        } else {
                            $li.removeClass('active')
                        }
                    });
                }
                else {
                    $collapse.collapse('hide')
                }
            });
        });
	}
}
export default NavbarV2
