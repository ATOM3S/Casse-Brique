class brickBreaker {

	constructor (elementId) {
		this.gameElt = document.getElementById(elementId);

		// Canvas
		this.canvas = document.createElement("canvas");
		this.ctx = this.canvas.getContext("2d");
		if (window.innerWidth>1200) {
			this.canvas.width = window.innerWidth/2;
		} else {
			this.canvas.width = window.innerWidth;
		}
		
		this.canvas.height = this.canvas.width*9/16;

		// Balle
		this.x = this.canvas.width/2;
		this.y = this.canvas.height-30; 

		// Paddle
		this.paddleHeight = this.canvas.width/48;
		this.rightPressed = false;
		this.leftPressed = false;

		// Briques
		this.brickColors = ['green', 'blue', 'yellow', 'orange', 'red'];
		this.brickRowCount = 4;
		this.brickColumnCount = 6;
		this.brickHeight = this.canvas.width/24;
		this.brickWidth = this.brickHeight*4;
		this.brickPadding = 0;
		this.brickOffsetTop = this.canvas.width/16;
		this.brickOffsetLeft = 0;

		this.bricks = [];
		var i = 0;
		for(var c=0; c<this.brickColumnCount; c++) {
		    this.bricks[c] = [];
		    for(var r=0; r<this.brickRowCount; r++) {
		        this.bricks[c][r] = { x: 0, y: 0, status: 1, color: i };
		        if (i < this.brickColors.length-1) {
	            	i++
	            } else {
	            	i = 0;
	            }
		    }
		}

		// Score
		this.brickBreaked = 0;
		this.score = 0;
		this.combo = 1;

		// Évènements
		document.addEventListener("keydown", this.keyDownHandler.bind(this), false);
		document.addEventListener("keyup", this.keyUpHandler.bind(this), false);
		this.canvas.addEventListener("touchstart", this.tactilTouchStart.bind(this), false);
		document.addEventListener("touchend", this.tactilTouchEnd.bind(this));
		//document.addEventListener("mousemove", this.mouseMoveHandler.bind(this), false); // controle à la souris

		// Choisir la difficulté
		this.chooseDifficulty();
	}

	// Choisir la difficulté
	chooseDifficulty() {
		// Bouton facile
		this.easyButton = document.createElement("button");
		this.easyButton.textContent = "facile";
		this.easyButton.addEventListener("click", this.easyMod.bind(this));
		this.easyButton.classList.add("m-5");
		this.easyButton.classList.add("btn-lg");
		this.easyButton.classList.add("btn-success");
		this.easyButton.setAttribute("type", "button");

		// Bouton normal
		this.normalButton = document.createElement("button");
		this.normalButton.textContent = "normal";
		this.normalButton.classList.add("m-5");
		this.normalButton.classList.add("btn-lg");
		this.normalButton.classList.add("btn-primary");
		this.normalButton.setAttribute("type", "button");
		this.normalButton.addEventListener("click", this.normalMod.bind(this));

		// Bouton difficile
		this.hardButton = document.createElement("button");
		this.hardButton.textContent = "difficile";
		this.hardButton.classList.add("m-5");
		this.hardButton.classList.add("btn-lg");
		this.hardButton.classList.add("btn-warning");
		this.hardButton.setAttribute("type", "button");
		this.hardButton.addEventListener("click", this.hardMod.bind(this));

		// Div contenant les boutons
		this.buttonsElt = document.createElement("div");

		this.buttonsElt.appendChild(this.easyButton);
		this.buttonsElt.appendChild(this.normalButton);
		this.buttonsElt.appendChild(this.hardButton);

		// Ajout de buttonsElt dans gameElt
		this.gameElt.appendChild(this.buttonsElt);
	}

	// Mode facile
	easyMod() {
		// On retire les boutons
		this.gameElt.removeChild(this.buttonsElt);

		// Couleur
		this.color = "green";

		// Balle 
		this.ballSpeedInit = this.canvas.width/144;
		this.dx = this.ballSpeedInit;
		this.dy = -this.ballSpeedInit;
		this.ballRadius = this.canvas.width/48;

		// Paddle
		this.paddleWidth = this.canvas.width/4.8;
		this.paddleX = (this.canvas.width-this.paddleWidth)/2;

		// Vies
		this.lives = 3;

		// Bonus (multiplicateur de score lié à la difficulté)
		this.bonus = 1;

		// Ajout du canvas dans l'element
		this.gameElt.appendChild(this.canvas);

		// Lancement de la fonction dessiner.
		this.draw();
	}

	// Mode normal
	normalMod() {
		// On retire les boutons
		this.gameElt.removeChild(this.buttonsElt);

		// Couleur
		this.color = "blue";

		// Balle 
		this.ballSpeedInit = this.canvas.width/120;
		this.dx = this.ballSpeedInit;
		this.dy = -this.ballSpeedInit;
		this.ballRadius = this.canvas.width/60;

		// Paddle
		this.paddleWidth = this.canvas.width/6.4;
		this.paddleX = (this.canvas.width-this.paddleWidth)/2;

		// Vies
		this.lives = 2;

		// Bonus
		this.bonus = 1.5;

		// Ajout du canvas dans l'element
		this.gameElt.appendChild(this.canvas);

		// Lancement de la fonction dessiner.
		this.draw();
	}

	// Mode difficile
	hardMod() {
		// On retire les boutons
		this.gameElt.removeChild(this.buttonsElt);

		// Couleur
		this.color = "orange";

		// Balle 
		this.ballSpeedInit = this.canvas.width/96;
		this.dx = this.ballSpeedInit;
		this.dy = -this.ballSpeedInit;
		this.ballRadius = this.canvas.width/80;

		// Paddle
		this.paddleWidth = this.canvas.width/9.6;
		this.paddleX = (this.canvas.width-this.paddleWidth)/2;

		// Vies
		this.lives = 1;

		// Bonus
		this.bonus = 2;

		// Ajout du canvas dans l'element
		this.gameElt.appendChild(this.canvas);

		// Lancement de la fonction dessiner.
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

	// 'Touche' enfoncé tactile
	tactilTouchStart(e) {
		if(e.targetTouches[0].clientX > this.canvas.width/2) {
	        this.rightPressed = true;
	    }
	    else if(e.targetTouches[0].clientX < this.canvas.width/2) {
	        this.leftPressed = true;
	    }
	}

	// Touche relaché tactile
	tactilTouchEnd() {
		this.rightPressed = false;
		this.leftPressed = false;
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
		            if(this.x > b.x-this.ballRadius && this.x < b.x+this.brickWidth+this.ballRadius && this.y > b.y-this.ballRadius && this.y < b.y+this.brickHeight+this.ballRadius) {
		                this.dy = -this.dy;
		                b.status = 0;
		                this.brickBreaked++;
		                this.score = this.score + (10*this.bonus)*this.combo;
		                this.combo++;
		                if(this.brickBreaked == this.brickRowCount*this.brickColumnCount) {
		                	this.score = this.score +  this.lives*10*this.bonus;
	                        alert("VOUS AVEZ GAGNÉ, FÉLICITATIONS!");
	                        var url = "index.php?action=sendScore&score=" + this.encryptScore(this.score);
				    		ajaxGet(url, this.redirection);
	                        //document.location.href="index.php?action=sendScore&score=" + this.encryptScore(this.score);
	                    }
		            }
	            }
	        }
	    }
	}

	// Afficher le score
	drawScore() {
	    this.ctx.font =  this.canvas.width/30 + "px Arial";
	    this.ctx.fillStyle = this.color;
	    this.ctx.fillText("Score: "+this.score, (this.canvas.width/60), (this.canvas.width/24));
	}

	// Affiche le nombre de vies
	drawLives() {
	    this.ctx.font = this.canvas.width/30 + "px Arial";
	    this.ctx.fillStyle = this.color;
	    this.ctx.fillText("Lives: "+this.lives, this.canvas.width-(this.canvas.width/8), (this.canvas.width/24));
	}

	// Dessiner la balle
	drawBall() {
		this.ctx.beginPath();
		this.ctx.arc(this.x, this.y, this.ballRadius, 0, Math.PI*2);
		this.ctx.fillStyle = this.color;
		this.ctx.fill();
		this.ctx.closePath();
	}

	// Dessiner le paddle
	drawPaddle() {
	    this.ctx.beginPath();
	    this.ctx.rect(this.paddleX, this.canvas.height-this.paddleHeight, this.paddleWidth, this.paddleHeight);
	    this.ctx.fillStyle = this.color;
	    this.ctx.fill();
	    this.ctx.closePath();
	}

	// Dessiner les briques
	drawBricks() {
		var i = 0;
	    for(var c=0; c<this.brickColumnCount; c++) {
	        for(var r=0; r<this.brickRowCount; r++) {
	        	if (this.bricks[c][r].status == 1) {
		        	var brickX = (c*(this.brickWidth+this.brickPadding))+this.brickOffsetLeft;
					var brickY = (r*(this.brickHeight+this.brickPadding))+this.brickOffsetTop;
		            this.bricks[c][r].x = brickX;
		            this.bricks[c][r].y = brickY;
		            this.ctx.beginPath();
		            this.ctx.rect(brickX, brickY, this.brickWidth, this.brickHeight);
		            this.ctx.fillStyle = this.brickColors[this.bricks[c][r].color];
		            this.ctx.fill();
		            this.ctx.closePath();
	            }
	        }
	    }
	}

	encryptScore(score) { 
		var cryptedScore = btoa(score);

		return cryptedScore;
	}

	redirection(link) {
		document.location.href = link;
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
				if (this.rightPressed) {
					this.dx = this.dx + this.canvas.width/240;
				} else if (this.leftPressed) {
					this.dx = this.dx - this.canvas.width/240;
				}
		        this.dy = -this.dy;
		        this.combo = 1;
		    } else {
			    this.lives--;
				if(!this.lives) {
				    alert("GAME OVER");
				    var url = "index.php?action=sendScore&score=" + this.encryptScore(this.score);
				    ajaxGet(url, this.redirection);
				    //document.location.href="index.php?action=sendScore&score=" + this.encryptScore(this.score);
				}
				else {
				    this.x = this.canvas.width/2;
				    this.y = this.canvas.height-(this.canvas.width/16);
				    this.dx = this.ballSpeedInit;
				    this.dy = -this.ballSpeedInit;
				    this.paddleX = (this.canvas.width-this.paddleWidth)/2;
				    this.combo = 1;
				}
		    }
		}

		if(this.x + this.dx > this.canvas.width-this.ballRadius || this.x + this.dx < this.ballRadius) {
			this.dx = -this.dx;
		}

		if(this.rightPressed && this.paddleX < this.canvas.width-this.paddleWidth) {
	    	this.paddleX += this.canvas.width/60;
		}
		else if(this.leftPressed && this.paddleX > 0) {
		    this.paddleX -= this.canvas.width/60;
		}

		this.x += this.dx;
		this.y += this.dy;
		requestAnimationFrame(this.draw.bind(this));
	}
}

//Construit la carte à la fin du chargement de la page
window.addEventListener("load", function(){
	const casseBrique = new brickBreaker("myCanvas");
});