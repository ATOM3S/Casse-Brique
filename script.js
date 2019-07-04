class brickBreaker {

	constructor () {
		// Canvas
		this.canvas = document.getElementById("myCanvas");
		this.ctx = this.canvas.getContext("2d");

		// Balle
		this.x = this.canvas.width/2;
		this.y = this.canvas.height-30;
		this.ballSpeed = 4;
		this.dx = this.ballSpeed;
		this.dy = -this.ballSpeed;
		this.ballRadius = 10;

		// Paddle
		this.paddleHeight = 10;
		this.paddleWidth = 75;
		this.paddleX = (this.canvas.width-this.paddleWidth)/2;
		this.rightPressed = false;
		this.leftPressed = false;

		// Briques
		this.brickRowCount = 3;
		this.brickColumnCount = 5;
		this.brickWidth = 75;
		this.brickHeight = 20;
		this.brickPadding = 10;
		this.brickOffsetTop = 30;
		this.brickOffsetLeft = 30;

		this.bricks = [];
		for(var c=0; c<this.brickColumnCount; c++) {
		    this.bricks[c] = [];
		    for(var r=0; r<this.brickRowCount; r++) {
		        this.bricks[c][r] = { x: 0, y: 0, status: 1 };
		    }
		}

		// Score
		this.score = 0;

		// Vies
		this.lives = 3;

		// Évènements
		document.addEventListener("keydown", this.keyDownHandler.bind(this), false);
		document.addEventListener("keyup", this.keyUpHandler.bind(this), false);
		document.addEventListener("mousemove", this.mouseMoveHandler.bind(this), false);

		this.draw();
	}

	// Touche enfoncé
	keyDownHandler(e) {
	    if(e.keyCode == 39) {
	        this.rightPressed = true;
	    }
	    else if(e.keyCode == 37) {
	        this.leftPressed = true;
	    }
	}

	// Touche relaché
	keyUpHandler(e) {
	    if(e.keyCode == 39) {
	        this.rightPressed = false;
	    }
	    else if(e.keyCode == 37) {
	        this.leftPressed = false;
	    }
	}

	// Mouvement de la souris
	mouseMoveHandler(e) {
	    var relativeX = e.clientX - this.canvas.offsetLeft;
	    if(relativeX > (0 + this.paddleWidth/2)  && relativeX < (this.canvas.width - this.paddleWidth/2)) {
	        this.paddleX = relativeX - this.paddleWidth/2;
	    }
	}

	// Détection des collisions
	collisionDetection() {
	    for(var c=0; c<this.brickColumnCount; c++) {
	        for(var r=0; r<this.brickRowCount; r++) {
	            var b = this.bricks[c][r];
	            if (b.status == 1) {
		            if(this.x > b.x && this.x < b.x+this.brickWidth && this.y > b.y && this.y < b.y+this.brickHeight) {
		                this.dy = -this.dy;
		                b.status = 0;
		                this.score++;
		                if(this.score == this.brickRowCount*this.brickColumnCount) {
	                        alert("YOU WIN, CONGRATULATIONS!");
	                        document.location.reload();
	                    }
		            }
	            }
	        }
	    }
	}

	// Afficher le score
	drawScore() {
	    this.ctx.font = "16px Arial";
	    this.ctx.fillStyle = "#0095DD";
	    this.ctx.fillText("Score: "+this.score, 8, 20);
	}

	// Affiche le nombre de vies
	drawLives() {
	    this.ctx.font = "16px Arial";
	    this.ctx.fillStyle = "#0095DD";
	    this.ctx.fillText("Lives: "+this.lives, this.canvas.width-65, 20);
	}

	// Dessiner la balle
	drawBall() {
		this.ctx.beginPath();
		this.ctx.arc(this.x, this.y, this.ballRadius, 0, Math.PI*2);
		this.ctx.fillStyle = "#0095DD";
		this.ctx.fill();
		this.ctx.closePath();
	}

	// Dessiner le paddle
	drawPaddle() {
	    this.ctx.beginPath();
	    this.ctx.rect(this.paddleX, this.canvas.height-this.paddleHeight, this.paddleWidth, this.paddleHeight);
	    this.ctx.fillStyle = "#0095DD";
	    this.ctx.fill();
	    this.ctx.closePath();
	}

	// Dessiner les briques
	drawBricks() {
	    for(var c=0; c<this.brickColumnCount; c++) {
	        for(var r=0; r<this.brickRowCount; r++) {
	        	if (this.bricks[c][r].status == 1) {
		        	var brickX = (c*(this.brickWidth+this.brickPadding))+this.brickOffsetLeft;
					var brickY = (r*(this.brickHeight+this.brickPadding))+this.brickOffsetTop;
		            this.bricks[c][r].x = brickX;
		            this.bricks[c][r].y = brickY;
		            this.ctx.beginPath();
		            this.ctx.rect(brickX, brickY, this.brickWidth, this.brickHeight);
		            this.ctx.fillStyle = "#0095DD";
		            this.ctx.fill();
		            this.ctx.closePath();
	            }
	        }
	    }
	}

	// Dessiner
	draw() {
		this.ctx.clearRect(0, 0, this.canvas.width, this.canvas.height);
		this.drawBricks();
		this.drawBall();
		this.drawPaddle();
		this.drawScore();
		this.drawLives();
		this.collisionDetection();

		if(this.y + this.dy < this.ballRadius) {
			this.dy = -this.dy;
		} else if(this.y + this.dy > this.canvas.height-this.ballRadius) {
			if(this.x > this.paddleX && this.x < this.paddleX + this.paddleWidth) {
		        this.dy = -this.dy;
		    } else {
			    this.lives--;
				if(!this.lives) {
				    alert("GAME OVER");
				    document.location.reload();
				}
				else {
				    this.x = this.canvas.width/2;
				    this.y = this.canvas.height-30;
				    this.dx = this.ballSpeed;
				    this.dy = -this.ballSpeed;
				    this.paddleX = (this.canvas.width-this.paddleWidth)/2;
				}
		    }
		}

		if(this.x + this.dx > this.canvas.width-this.ballRadius || this.x + this.dx < this.ballRadius) {
			this.dx = -this.dx;
		}

		if(this.rightPressed && this.paddleX < this.canvas.width-this.paddleWidth) {
	    	this.paddleX += 7;
		}
		else if(this.leftPressed && this.paddleX > 0) {
		    this.paddleX -= 7;
		}

		this.x += this.dx;
		this.y += this.dy;
		requestAnimationFrame(this.draw.bind(this));
	}
}

//Construit la carte à la fin du chargement de la page
window.addEventListener("load", function(){
	const casseBrique = new brickBreaker();
});