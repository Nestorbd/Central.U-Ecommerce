import { Component, ElementRef, ViewChild } from "@angular/core";
import {
  NgxMoveableModule,
  NgxMoveableComponent,
} from "ngx-moveable";

@Component({
  selector: 'app-pruebacdk',
  templateUrl: './pruebacdk.page.html',
  styleUrls: ['./pruebacdk.page.scss'],
})
export class PruebacdkPage {
  @ViewChild("target", { static: false }) target: ElementRef;
  frame = {
    rotate: 0,
};
onRotateStart({ set }) {
    set(this.frame.rotate);
}
onRotate({ target, beforeRotate }) {
    this.frame.rotate = beforeRotate;
    target.style.transform = `rotate(${beforeRotate}deg)`;
}
onRotateEnd({ target, isDrag, clientX, clientY }) {
    console.log("onRotateEnd", target, isDrag);
}
}
