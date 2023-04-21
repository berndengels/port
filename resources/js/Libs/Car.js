
class Car {
	info(url, triggerSelector, tooltipSelector) {
		const $triggerSelector = $(triggerSelector)
		$triggerSelector.click((e) => {
			let $tt = $(tooltipSelector)
			if($tt.is(":visible")) {
				$tt.hide()
			}
			axios.get(url + "?carnumber=" + e.target.innerText)
				.then(resp => {
					if(resp.data.data && !resp.data.error) {
						let info = resp.data.data,
							txt = info.location + " (" + info.state + ")",
							offset = $(e.target).offset(),
							$tt = $(tooltipSelector);
						$tt.css({top: offset.top - 35, left: offset.left + 30, zIndex: 1000})
							.show()
							.find('.txt').html(txt)
							.end()
							.click(e => $tt.hide())
						;
						setInterval(() => $tt.fadeOut(), 3000)
					}
				})
				.catch(e=>console.error(e));
		});
	}
}
export default Car
