import { Component, ViewChild, OnInit, AfterViewInit, ElementRef } from "@angular/core";
import { NgxMoveableComponent } from "ngx-moveable";
import { NgxSelectoComponent } from "ngx-selecto";
import type { OnRotate, OnPinch } from 'moveable';
import { Frame } from 'scenejs';
import { ArticuloService } from "src/app/services/articulo.service";
@Component({
  selector: 'app-boceto',
  templateUrl: './boceto.page.html',
  styleUrls: ['./boceto.page.scss'],
})
export class BocetoPage implements OnInit {
  @ViewChild('moveable', { static: false }) moveable: NgxMoveableComponent;
  @ViewChild('selecto', { static: false }) selecto: NgxSelectoComponent;
  src: string;
  cubes = [];
  targets = [];
  frameMap = new Map();
  frame = {
    translate: [0, 0],
    rotate: 0,
  };



  constructor(
    private articuloSrv: ArticuloService
  ) { }

  ngOnInit() {
    this.getSrc()
    const cubes = [];

    for (let i = 0; i < 30; ++i) {
      cubes.push(i);
    }
    this.cubes = cubes;
  }



  ionViewWillEnter(){
    this.src
  }
  
  getBackgroundImageUrl(){
    console.log(this.src)
    return this.src
  }

  getSrc(){
    
    this.src = this.articuloSrv.getImagen()
  }

  onClickGroup(e) {
    this.selecto.clickTarget(e.inputEvent, e.inputTarget);
  }
  onMoveableDragStart(e) {
    const target = e.target;

    if (!this.frameMap.has(target)) {
      this.frameMap.set(target, {

        translate: [0, 0],
      });
    }
    const frame = this.frameMap.get(target);

    e.set(frame.translate);
  }


  onDrag(e) {
    const target = e.target;
    const frame = this.frameMap.get(target);

    frame.translate = e.beforeTranslate;
    target.style.transform = `translate(${frame.translate[0]}px, ${frame.translate[1]}px)`;
  }
  onDragGroupStart(e) {
    e.events.forEach(ev => {
      const target = ev.target;

      if (!this.frameMap.has(target)) {
        this.frameMap.set(target, {
          translate: [0, 0],
        });
      }
      const frame = this.frameMap.get(target);

      ev.set(frame.translate);
    });
  }

  onDragGroup(e) {
    e.events.forEach(ev => {
      const target = ev.target;
      const frame = this.frameMap.get(target);

      frame.translate = ev.beforeTranslate;
      target.style.transform = `translate(${frame.translate[0]}px, ${frame.translate[1]}px)`;
    });
  }
  onDragStart(e) {
    const target = e.inputEvent.target;

    if (
      this.moveable.isMoveableElement(target)
      || this.targets.some(t => t === target || t.contains(target))
    ) {

      e.stop();
    }
  }
  onSelectEnd(e) {
    this.targets = e.selected;

    if (e.isDragStart) {
      e.inputEvent.preventDefault();

      setTimeout(() => {
        this.moveable.ngDragStart(e.inputEvent);
      });
    }
  }

  onResizeStart(e) {
    e.setOrigin(["%", "%"]);
    e.dragStart && e.dragStart.set(this.frame.translate);
  }
  onResize(e) {
    const beforeTranslate = e.drag.beforeTranslate;

    this.frame.translate = beforeTranslate;
    e.target.style.width = `${e.width}px`;
    e.target.style.height = `${e.height}px`;
    e.target.style.transform = `translate(${beforeTranslate[0]}px, ${beforeTranslate[1]}px)`;
  }
  onDragEnd($event) {
    console.log("lol")
  }

}
