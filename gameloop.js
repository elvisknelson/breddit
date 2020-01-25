var Particle = (function (){
	var create = function(x, y) {
		var obj = Object.create(def);

		obj.pos = Vec2D.create(x, y);
		obj.vel = Vec2D.create(0, 0);
		obj.lifespan = 80;
		obj.radius = Math.random() * 3 + 2;

		return obj;
	};

	var def = {
		pos: null,
		vel: null,
		lifespan: null,
		radius: null,
		color: null,
		
		update: function() {
			this.pos.add(this.vel);
			this.vel.mul(0.98);
			this.lifespan--;
			this.radius -= 0.1;

			if(this.radius < 0.1) this.radius = 0.1;
		}
	}

	return {create:create};
}());

var Ship = (function(){
	var create = function(x, y) {
		var obj = Object.create(def);
		obj.angle = 0;
		obj.radius = 10;
		obj.bulletDelay = 0;
		obj.mineDelay = 0;
		obj.pos = Vec2D.create(x, y);
		obj.thrust = Vec2D.create(0, 0);
		obj.vel = Vec2D.create(0, 0);
		return obj;
	};

	var def = {
		angle: null,
		pos: null,
		thrust: null,
		vel: null,
		blacklisted: null,
		radius: null,
		bulletDelay: null,
		mineDelay: null,

		update: function() {
			this.vel.add(this.thrust);
			this.pos.add(this.vel);

			if(this.bulletDelay > 0)
			{
				this.bulletDelay--;
			}

			if(this.mineDelay > 0)
			{
				this.mineDelay--;
			}

			if(this.vel.getLength() > 4) this.vel.setLength(4);

			if(this.pos.getX() < 0)
			{
				this.pos.setX(window.innerWidth);
			}
			else if(this.pos.getX() > window.innerWidth)
			{
				this.pos.setX(0);
			}

			if(this.pos.getY() < 0)
			{
				this.pos.setY(window.innerHeight);
			}
			else if(this.pos.getY() > window.innerHeight)
			{
				this.pos.setY(0);
			}
		},

	};

	return {create:create};

}());

var Vec2D = (function(){
	var create = function(x, y) {
		var obj = Object.create(def);
		obj.setXY(x, y);

		return obj;
	};

	var def = {
		_x: 0,
		_y: 0,

		setXY: function(x, y) {
			this._x = x;
			this._y = y;
		},

		setX: function(x) {
			this._x = x;
		},

		setY: function(y) {
			this._y = y;
		},

		getX: function() {
			return this._x;
		},

		getY: function() {
			return this._y;
		},

		add: function(vector) {
			this._x += vector.getX();
			this._y += vector.getY();
		},

		sub: function(vector) {
			this._x -= vector.getX();
			this._y -= vector.getY();
		},

		setLength: function(length) {
			var angle = this.getAngle();
			this._x = Math.cos(angle) * length;
			this._y = Math.sin(angle) * length;
		},

		getLength: function() {
			return Math.sqrt(this._x * this._x + this._y * this._y);
		},

		getAngle: function() {
			return Math.atan2(this._y, this._x);
		},

		setAngle: function(angle) {
			var length = this.getLength();
			this._x = Math.cos(angle) * length;
			this._y = Math.sin(angle) * length;
		},

		mul: function(val) {
			this._x *= val;
			this._y *= val;
		}
	};

	return {create:create};
}());

var Bullet = (function() {
	var create = function(x, y) {
		var obj = Object.create(def);
		obj.pos = Vec2D.create(x, y);
		obj.vel = Vec2D.create(0, 0);
		obj.radius = 1;
		return obj;
	}

	var def = {
		pos: null,
		vel: null,
		lifespan: null,
		radius: null,
		bulletDelay: null,
		blacklisted: null,

		update: function() {
			this.pos.add(this.vel);

			if(this.pos.getX() < 0)
			{
				this.blacklisted = true;
			}
			else if(this.pos.getX() > window.innerWidth)
			{
				this.blacklisted = true;
			}

			if(this.pos.getY() < 0)
			{
				this.blacklisted = true;
			}
			else if(this.pos.getY() > window.innerHeight)
			{
				this.blacklisted = true;
			}
		}
	}

	return {create:create};
}());

var Asteroid = (function () {
	var create = function(x, y) {
		var obj = Object.create(def);
		obj.pos = Vec2D.create(x, y);
		obj.vel = Vec2D.create(0, 0);
		obj.color = "black";
		obj.angle = 0;
		obj.spinDir = (Math.random() > 0.5) ? 0.007 : -0.009;
		return obj;
	}

	var def = {
		pos: null,
		vel: null,
		radius: null,
		angle: null,
		blacklisted: null,
		lineWidth: null,
		spinDir: null,
		color: null,
		
		update: function() {
			this.pos.add(this.vel);
			this.angle += this.spinDir;

			if(this.pos.getX() < 0)
			{
				this.pos.setX(window.innerWidth);
			}
			else if(this.pos.getX() > window.innerWidth)
			{
				this.pos.setX(0);
			}

			if(this.pos.getY() < 0)
			{
				this.pos.setY(window.innerHeight);
			}
			else if(this.pos.getY() > window.innerHeight)
			{
				this.pos.setY(0);
			}
		}
	};

	return {create:create};
}());

var Rocket = (function() {
	var create = function(x, y) {
		var obj = Object.create(def);
		obj.pos = Vec2D.create(x, y);
		obj.vel = Vec2D.create(0, 0);
		obj.radius = 5;
		obj.angle = 0;
		obj.blacklisted = true;
		return obj;
	};

	var def = {
		pos: null,
		vel: null,
		blacklisted: null,
		radius: null,
		angle: null,
		target: null,

		update: function() {
			this.vel.setAngle(this.angle);
			this.pos.add(this.vel);

			if(this.pos.getX() < 0)
			{
				this.blacklisted = true;
			}
			else if(this.pos.getX() > window.innerWidth)
			{
				this.blacklisted = true;
			}

			if(this.pos.getY() < 0)
			{
				this.blacklisted = true;
			}
			else if(this.pos.getY() > window.innerHeight)
			{
				this.blacklisted = true;
			}

			let part = Particle.create(this.pos.getX() + Math.cos(this.angle) * -10, this.pos.getY() + Math.sin(this.angle) * -10);
			part.lifespan = 5;
			part.radius = 2;
			part.vel.setLength(3);
			part.color = "orange";
			part.vel.setAngle(this.angle + (1 - Math.random() * 4) * (Math.PI / 15));
			part.vel.mul(-1);
			particlePool.push(part);
			
			if(this.target.pos != null && this.pos != null) this.angle = getAngle(this.target, rocket);
		}
	};

	return {create:create};
}());

var Mine = (function() {
	var create = (function(x, y) {
		var obj = Object.create(def);
		obj.pos = Vec2D.create(x, y);
		obj.radius = 10;
		obj.lightRadius = 10;
		obj.blinkRate = 0.15;
		return obj;
	});

	var def = {
		pos: null,
		radius: null,
		blacklisted: null,
		angle: null,
		blinkRate: null,

		update: function() {
			this.radius += this.blinkRate;

			if(this.radius > 25) this.blinkRate *= -1;
			if(this.radius < 10) this.blinkRate *= -1;
		}
	};

	return {create:create};
}());

function getAngle(obj1, obj2) {
	result = Math.atan2(obj1.pos.getY() - obj2.pos.getY(), obj1.pos.getX() - obj2.pos.getX());
	return result;
}

function findClosest() {
	var min = 0;
	var cur = 0;
	var result = 0;

	for (let i = 0; i < asteroidPool.length; i++) {
		let xV = asteroidPool[i].pos.getX() - ship.pos.getX();
		let yV = asteroidPool[i].pos.getY() - ship.pos.getY();
		let vec = Vec2D.create(xV, yV);
		cur = Math.abs(vec.getLength());
		if(i == 0) min = cur;
		
		if(cur <= min)
		{
			min = cur;
			result = asteroidPool[i];
		}
	}
	result.color = "red";
	return result;
}

function reset() {
	ship.blacklisted = false;
	ship.pos.setX(window.innerWidth / 2);
	ship.pos.setY(window.innerHeight / 2);
	ship.vel.mul(0);
	ship.angle = 0;

	bulletPool = [];
	asteroidPool = [];
	particlePool = [];
}

function random(min, max) {
	return Math.floor(Math.random() * (max - min)) + min;
}

function randomNoFloor(min, max) {
	return (Math.random() * (max - min)) + min;
}

function shoot() {
	if(ship.bulletDelay == 0)
	{
		let bullet = Bullet.create(ship.pos.getX(), ship.pos.getY());
		bullet.vel.setLength(6);
		bullet.vel.setAngle(ship.angle);
		bulletPool.push(bullet);
		ship.bulletDelay = 25;
	}
}

function fireRocket() {
	if(findClosest() != null && rocket.blacklisted)
	{
		rocket.blacklisted = false;
		rocket.pos.setXY(ship.pos.getX(), ship.pos.getY());
		rocket.vel.setLength(2);
		rocket.vel.setAngle(ship.angle);
		rocket.target = findClosest();
	}
}

function launchMine() {
	if(ship.mineDelay == 0 && minePool.length < 3)
	{
		let mine = Mine.create(ship.pos.getX(), ship.pos.getY());
		minePool.push(mine);
		ship.mineDelay = 150;
	}
}

function checkCollision(obj1, obj2) {
	let xV = obj1.pos.getX() - obj2.pos.getX();
	let yV = obj1.pos.getY() - obj2.pos.getY();
	let vec = Vec2D.create(xV, yV);

	if(vec.getLength() < obj1.radius + obj2.radius)
	{
		return true;
	}
}

function checkCollisions() {
	for (let i = 0; i < asteroidPool.length; i++) {
		if(!ship.blacklisted)
		{
			if(checkCollision(ship, asteroidPool[i]))
			{
				ship.blacklisted = true;
				rocket.blacklisted = true;

				generateShipExplosion();

				setTimeout(reset, 3000);
			}
		}

		if(!rocket.blacklisted)
		{
			if(checkCollision(rocket, asteroidPool[i]) && !rocket.blacklisted)
			{
				generateExplosion(asteroidPool[i], "black");

				asteroidPool[i].blacklisted = true;
				rocket.blacklisted = true;
				rocket.target = null;
				generateExplosion(rocket);

				if(asteroidPool[i].radius > 50)
				{
					generateAsteroid(asteroidPool[i].pos.getX(), asteroidPool[i].pos.getY(), random(25, 45));
					generateAsteroid(asteroidPool[i].pos.getX(), asteroidPool[i].pos.getY(), random(25, 45));
				}
			}
		}

		for (let k = 0; k < minePool.length; k++) 
		{
			if(checkCollision(minePool[k], asteroidPool[i]) && !minePool[k].blacklisted)
			{
				generateExplosion(asteroidPool[i], "black");

				asteroidPool[i].blacklisted = true;
				minePool[k].blacklisted = true;

				if(asteroidPool[i].radius > 50)
				{
					generateAsteroid(asteroidPool[i].pos.getX(), asteroidPool[i].pos.getY(), random(25, 45));
					generateAsteroid(asteroidPool[i].pos.getX(), asteroidPool[i].pos.getY(), random(25, 45));
				}
			}
		}
		
		for (let j = 0; j < bulletPool.length; j++) 
		{
			if(checkCollision(bulletPool[j], asteroidPool[i]) && !bulletPool[j].blacklisted)
			{
				generateExplosion(asteroidPool[i], "black");

				if(asteroidPool[i] == rocket.target)
				{
					rocket.blacklisted = true;
					rocket.target = null;
					generateExplosion(rocket);
				}
				
				asteroidPool[i].blacklisted = true;
				bulletPool[j].blacklisted = true;

				if(asteroidPool[i].radius > 50)
				{
					generateAsteroid(asteroidPool[i].pos.getX(), asteroidPool[i].pos.getY(), random(25, 45));
					generateAsteroid(asteroidPool[i].pos.getX(), asteroidPool[i].pos.getY(), random(25, 45));
				}
			}
		}
	}
}

function renderMines() {
	if(minePool.length > 0)
	{
		var i = minePool.length - 1;
		
		for (i; i > -1; --i) {
			if(!minePool[i].blacklisted)
			{
				ctx.beginPath();
				ctx.strokeStyle = "red";
				ctx.arc(minePool[i].pos.getX() >> 0, minePool[i].pos.getY() >> 0, minePool[i].radius, 0, Math.PI * 2);
				ctx.stroke();
				ctx.closePath();

				ctx.beginPath();
				ctx.strokeStyle = "red";
				ctx.arc(minePool[i].pos.getX() >> 0, minePool[i].pos.getY() >> 0, minePool[i].lightRadius, 0, Math.PI * 2);
				ctx.stroke();
				ctx.closePath();
			}
		}
	}
}

function renderRocket() {
	if(!rocket.blacklisted)
	{
		ctx.save();
		ctx.translate(rocket.pos.getX() >> 0, rocket.pos.getY() >> 0);
		ctx.rotate(rocket.angle);
		ctx.beginPath();
		ctx.strokeStyle = "red";
		ctx.moveTo(rocket.radius, 0);
		ctx.lineTo(-rocket.radius, -rocket.radius);
		ctx.lineTo(-rocket.radius, rocket.radius);
		ctx.lineTo(rocket.radius, 0);
		ctx.stroke();
		ctx.closePath();

		ctx.restore();
	}
}

function renderBullets() {
	if(bulletPool.length > 0)
	{
		var i = bulletPool.length - 1;
		
		for (i; i > -1; --i) {
			if(!bulletPool[i].blacklisted)
			{
				ctx.beginPath();
				ctx.strokeStyle = "white";
				ctx.arc(bulletPool[i].pos.getX() >> 0, bulletPool[i].pos.getY() >> 0, bulletPool[i].radius, 0, Math.PI * 2);
				ctx.stroke();
				ctx.closePath();
			}
		}
	}
}

function renderParticles() {
	if(particlePool.length > 0)
	{
		var i = particlePool.length - 1;

		for (i; i > -1; --i) {
			ctx.save();
			ctx.beginPath();
			ctx.strokeStyle = particlePool[i].color;
			ctx.arc(particlePool[i].pos.getX(), particlePool[i].pos.getY(), particlePool[i].radius, 0, 2 * Math.PI);
			ctx.stroke();
			ctx.restore();
		}
	}
}

function renderShip() {
	if(!ship.blacklisted)
	{
		ctx.save();
		ctx.translate(ship.pos.getX() >> 0, ship.pos.getY() >> 0);
		ctx.rotate(ship.angle);

		ctx.beginPath();
		ctx.strokeStyle = "white";
		ctx.moveTo(10, 0);
		ctx.lineWidth = 2;
		ctx.lineTo(-ship.radius, -ship.radius);
		ctx.lineTo(-ship.radius, ship.radius);
		ctx.lineTo(ship.radius, 0);
		ctx.stroke();
		ctx.closePath();

		ctx.restore();
	}
}

function renderAsteroids() {
	if(asteroidPool.length > 0)
	{
		var points = 8;
		var i = asteroidPool.length - 1;
		var disBetween = 6.28 / points;
		var angle = disBetween;

		for (i; i > -1; --i) {
			if(!asteroidPool[i].blacklisted)
			{
				ctx.beginPath();
				ctx.lineWidth = asteroidPool[i].lineWidth;
				ctx.strokeStyle = asteroidPool[i].color;
				ctx.moveTo(asteroidPool[i].pos.getX() + Math.cos(angle + asteroidPool[i].angle) * asteroidPool[i].radius, asteroidPool[i].pos.getY() + Math.sin(angle + asteroidPool[i].angle) * asteroidPool[i].radius);

				for (let j = 0; j < points; j++) {
					angle += disBetween;
					ctx.lineTo(asteroidPool[i].pos.getX() + Math.cos(angle + asteroidPool[i].angle) * asteroidPool[i].radius, asteroidPool[i].pos.getY() + Math.sin(angle + asteroidPool[i].angle) * asteroidPool[i].radius);
					ctx.stroke();
				}
			}
		}
	}
}

function render() {
	ctx.fillStyle = '#565656';
	ctx.fillRect(0, 0, window.innerWidth, window.innerHeight);

	renderBullets();
	renderShip();
	renderParticles();
	renderAsteroids();
	renderRocket();
	renderMines();
}

function keyboardInit() {

    window.onkeydown = function(e) {
        switch(e.keyCode) {
			case 82:
			keyR = true;
			break;

			case 81:
			keyQ = true;
			break;

            case 65:
			case 37:
			keyLeft = true;
			break;

			case 87:
			case 38:
			keyUp = true;
			break;

			case 68:
			case 39:
			keyRight = true;
			break;

			case 83:
			case 40:
			keyDown = true;
			break;

			case 32:
            case 75:
			keySpace = true;
			break;
		}
    
    e.preventDefault();
	};

	window.onkeyup = function(e)
	{
		switch(e.keyCode)
		{
			case 82:
			keyR = false;
			break;

			case 81:
			keyQ = false;
			break;

			case 65:
			case 37:
			keyLeft = false;
			break;

			case 87:
			case 38:
			keyUp = false;
			break;

			case 68:
			case 39:
			keyRight = false;
			break;

			case 83:
			case 40:
			keyDown = false;
			break;

            case 75:
			case 32:
			keySpace = false;
			break;
        }
    }
}

function generateThrustParticle() {
	let part = Particle.create(ship.pos.getX() + Math.cos(ship.angle) * -14, ship.pos.getY() + Math.sin(ship.angle) * -14);
	part.vel.setLength(3);
	part.color = "orange";
	part.lifespan = random(80, 120);
	part.vel.setAngle(ship.angle + (1 - Math.random() * 5) * (Math.PI / 18));
	part.vel.mul(-1);
	particlePool.push(part);
}

function generateAsteroid(x = random(0, window.innerWidth), y = random(0, 200), radius = random(45, 70)) {
	let asteroid = Asteroid.create(x, y);
	asteroid.lineWidth = (Math.random() > 0.75) ? 4 : 3;
	asteroid.vel.setLength(randomNoFloor(0.1, 1.5));
	asteroid.vel.setAngle(randomNoFloor(0, 6.2));
	asteroid.radius = radius;
	asteroidPool.push(asteroid);
}

function generateShipExplosion() {
	for (let i = 0; i < random(25, 65); i++) {
		let part = Particle.create(ship.pos.getX(), ship.pos.getY());
		part.color = "white";
		part.vel.setLength(randomNoFloor(1, 3));
		part.vel.setAngle(randomNoFloor(0, 6.28));
		particlePool.push(part);
	}
}

function generateExplosion(obj, color = "orange") {
	for (let i = 0; i < random(25, 65); i++) {
		let part = Particle.create(obj.pos.getX(), obj.pos.getY());
		part.color = color;
		part.vel.setLength(randomNoFloor(1, 3));
		part.vel.setAngle(randomNoFloor(0, 6.28));
		particlePool.push(part);
	}
}

function updateMines() {
	if(minePool.length > 0)
	{
		for(let i = 0; i < minePool.length; i++)
		{
			if(!minePool[i].blacklisted)
			{
				minePool[i].update();
			}
			if(minePool[i].blacklisted)
			{
				minePool.splice(i, 1);
			}
		}
	}
}

function updateRocket() {
	if(!rocket.blacklisted)
	{
		rocket.update();
	}
}

function updateParticles() {
	
	if(particlePool.length > 0)
	{
		for (let i = 0; i < particlePool.length; i++) {
			particlePool[i].update();
			if(particlePool[i].lifespan <= 0)
			{
				particlePool.splice(i, 1);
			}
		}
	}
}

function updateBullets()
{
	if(bulletPool.length > 0)
	{
		for(let i = 0; i < bulletPool.length; i++)
		{
			if(!bulletPool[i].blacklisted)
			{
				bulletPool[i].update();
			}
			if(bulletPool[i].blacklisted)
			{
				bulletPool.splice(i, 1);
			}
		}
	}
}

function updateShip() {
	
	if(!ship.blacklisted)
	{
		ship.update();
		if(keyLeft) ship.angle -= 0.02;
		if(keyRight) ship.angle += 0.02;
		
		if(keyUp)
		{
			ship.thrust.setLength(0.02);
			ship.thrust.setAngle(ship.angle);
			generateThrustParticle();
		}
		else
		{
			ship.vel.mul(0.98);
			ship.thrust.setLength(0);
		}

		if(keySpace)
		{
			shoot();
		}

		if(keyR)
		{
			if(rocket.blacklisted)
			{
				fireRocket();
			}
		}

		if(keyQ)
		{
			launchMine();
		}
	}
}

function updateAsteroids() {
	if(asteroidPool.length < numAsteroids)
	{
		generateAsteroid();
	}

	if(asteroidPool.length > 0)
	{
		for (let i = 0; i < asteroidPool.length; i++) {
			if(!asteroidPool[i].blacklisted)
			{
				asteroidPool[i].update();
			}
			else
			{
				asteroidPool.splice(i, 1);
			}
		}
	}
}

//#region Variables
window.requestAnimationFrame(loop);

var keyLeft, keyRight, keySpace, keyUp, keyDown, keyR, keyQ = false;
var piConversion = Math.PI/180;
var numAsteroids = 6;

var canvas;
var ctx;
var ship = Ship.create(window.innerWidth / 2, window.innerHeight / 2);
var rocket = Rocket.create(0, 0);
var colors = ["#FF8000", "#FF4614", "#FF8000", "#FF931B", "#FF8000"];

var particlePool = [];
var bulletPool = [];
var asteroidPool = [];
var minePool = [];
//#endregion

window.onload = function()
{
    keyboardInit();

	canvas = document.getElementById("canvas");
	canvas.width  = window.innerWidth;
	canvas.height = window.innerHeight;
	ctx = canvas.getContext("2d");

	loop();
};

function loop() {
	updateParticles();
	updateBullets();
	updateAsteroids();
	updateShip();
	updateRocket();
	updateMines();

	checkCollisions();

	render();

    requestAnimationFrame(loop);
}
