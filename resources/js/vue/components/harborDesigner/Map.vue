<template>
	<div class="row">
		<div class="col" id="container"></div>
		<div class="col">
			<form @submit.prevent>
				<button>neuer Steg</button>
				<button>neue Boxen</button>
			</form>
		</div>
	</div>
</template>

<script>
import "konva";

export default {
	name: "Map",
	data() {
		return {
			count: 11,
			w: 10,
			h: 40,
			color: 'red',
			labels: [],
			data: [],
		}
	},
	mounted() {
		const $map = $('#container'),
			stage = new Konva.Stage({
				container: 'container',
				width: window.innerWidth,
				height: window.innerHeight,
				draggable: true,
			}),
			textInitial = this.getText(),
			labelInitial = this.getLabel();

		const layer = new Konva.Layer();
		stage.add(layer);
		let pos = 0;

		for (let i = 1; i < this.count + 1; i++) {
			let label = labelInitial.clone({
				x: pos,
				y: stage.y(),
				id: "A" + i,
			});
			let text = textInitial.clone({
				text: i,
			});
			label.add(text);
			layer.add(label);

			this.labels.push(label);
			this.data.push({
				id: label.id(),
				x: label.x(),
				y: label.y(),
				text: label.getText().text(),
			});
			label.on('click', e => {
				console.info("label", label.id());
			});
			pos = pos + this.w + 1;
		}

		const tr = new Konva.Transformer({
			nodes: this.labels,
			boundBoxFunc: (oldBox, newBox) => {
				const box = this.getClientRect(newBox);
				const isOut =
					box.x < 0 ||
					box.y < 0 ||
					box.x + box.width > stage.width() ||
					box.y + box.height > stage.height();

				// if new bounding box is out of visible viewport, let's just skip transforming
				// this logic can be improved by still allow some transforming if we have small available space
				if (isOut) {
					return oldBox;
				}
				return newBox;
			},
		});
		layer.add(tr);

		// we can use transformer event
		// or just label event
		tr.on('dragmove', () => {
			const boxes = tr.nodes().map((node) => node.getClientRect());
			const box = this.getTotalBox(boxes);
			tr.nodes().forEach((label) => {
				const absPos = label.getAbsolutePosition();
				// where are shapes inside bounding box of all shapes?
				const offsetX = box.x - absPos.x;
				const offsetY = box.y - absPos.y;

				// we total box goes outside of viewport, we need to move absolute position of label
				const newAbsPos = {...absPos};
				if (box.x < 0) {
					newAbsPos.x = -offsetX;
				}
				if (box.y < 0) {
					newAbsPos.y = -offsetY;
				}
				if (box.x + box.width > stage.width()) {
					newAbsPos.x = stage.width() - box.width - offsetX;
				}
				if (box.y + box.height > stage.height()) {
					newAbsPos.y = stage.height() - box.height - offsetY;
				}
				label.setAbsolutePosition(newAbsPos);
			});
		});
	},
	methods: {
		getLabel() {
			let label = new Konva.Label({
				opacity: 1,
//                draggable: true,
			});
			label.add(
				new Konva.Tag({
					width: this.w,
					height: this.h,
					fill: 'red',
					lineJoin: 'round',
					cornerRadius: 5,
				})
			);
			return label;
		},
		getText() {
			return new Konva.Text({
				fontSize: 9,
//                fontStyle: "bold",
				fontFamily: 'Calibri',
				fill: '#fff',
//                width: this.w,
				padding: 2,
				align: 'center',
			});
		},
		getCorner(pivotX, pivotY, diffX, diffY, angle) {
			const distance = Math.sqrt(diffX * diffX + diffY * diffY);

			/// find angle from pivot to corner
			angle += Math.atan2(diffY, diffX);

			/// get new x and y and round it off to integer
			const x = pivotX + distance * Math.cos(angle);
			const y = pivotY + distance * Math.sin(angle);

			return {x: x, y: y};
		},
		getClientRect(rotatedBox) {
			const {x, y, width, height} = rotatedBox;
			const rad = rotatedBox.rotation;

			const p1 = this.getCorner(x, y, 0, 0, rad);
			const p2 = this.getCorner(x, y, width, 0, rad);
			const p3 = this.getCorner(x, y, width, height, rad);
			const p4 = this.getCorner(x, y, 0, height, rad);

			const minX = Math.min(p1.x, p2.x, p3.x, p4.x);
			const minY = Math.min(p1.y, p2.y, p3.y, p4.y);
			const maxX = Math.max(p1.x, p2.x, p3.x, p4.x);
			const maxY = Math.max(p1.y, p2.y, p3.y, p4.y);

			return {
				x: minX,
				y: minY,
				width: maxX - minX,
				height: maxY - minY,
			};
		},
		getTotalBox(boxes) {
			let minX = Infinity;
			let minY = Infinity;
			let maxX = -Infinity;
			let maxY = -Infinity;

			boxes.forEach((box) => {
				minX = Math.min(minX, box.x);
				minY = Math.min(minY, box.y);
				maxX = Math.max(maxX, box.x + box.width);
				maxY = Math.max(maxY, box.y + box.height);
			});
			return {
				x: minX,
				y: minY,
				width: maxX - minX,
				height: maxY - minY,
			};
		},
	}
}
</script>

<style scoped>
#container {
	width: 100%;
	height: 600px;
	border-color: 1px solid #ccc;
	background-image: url('/img/harbor-netzelkow-satellite.jpg');
	background-repeat: no-repeat;
	background-size: contain;
}
</style>
