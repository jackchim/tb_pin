(function(){
	var Mclass=function(){
			var Klass = function(){
				this.init=function(){};
				this.init.apply(this,arguments);
			}
			Klass.fn = Klass.prototype;
			Klass.extend = function(Obj){
				if(typeof Obj !="object")
				return;
				for(var args in Obj){
					Klass[args] = Obj[args];
				}
			}
			Klass.include = function(Obj){
				if(typeof Obj !="object")
				return;
				for(var args in Obj){
					Klass.fn[args] = Obj[args];
				}
			}
			return Klass;
		
}
if(!window.Mclass)
window.Mclass = Mclass;
})();
