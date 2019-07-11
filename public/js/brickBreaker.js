class brickBreaker {

	constructor (elementId) {
		this.gameElt = document.getElementById(elementId);

		// Canvas
		this.canvas = document.createElement("canvas");
		this.ctx = this.canvas.getContext("2d");
		this.canvas.width = "480";
		this.canvas.height = "320";

		// Balle
		this.x = this.canvas.width/2;
		this.y = this.canvas.height-30; 
		//this.ballSpeed = 4;
		//this.dx = this.ballSpeed;
		//this.dy = -this.ballSpeed;
		//this.ballRadius = 10;

		// Paddle
		this.paddleHeight = 10;
		//this.paddleWidth = 75;
		//this.paddleX = (this.canvas.width-this.paddleWidth)/2;
		this.rightPressed = false;
		this.leftPressed = false;

		// Briques
		this.brickColors = ['green', 'blue', 'orange'];
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
		this.brickBreaked = 0;
		this.score = 0;
		this.combo = 1;

		// Évènements
		document.addEventListener("keydown", this.keyDownHandler.bind(this), false);
		document.addEventListener("keyup", this.keyUpHandler.bind(this), false);
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

		// Bouton normal
		this.normalButton = document.createElement("button");
		this.normalButton.textContent = "normal";
		this.normalButton.addEventListener("click", this.normalMod.bind(this));

		// Bouton difficile
		this.hardButton = document.createElement("button");
		this.hardButton.textContent = "difficile";
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
		this.ballSpeedInit = 3;
		this.dx = this.ballSpeedInit;
		this.dy = -this.ballSpeedInit;
		this.ballRadius = 10;

		// Paddle
		this.paddleWidth = 100;
		this.paddleX = (this.canvas.width-this.paddleWidth)/2;

		// Vies
		this.lives = 3;

		// Bonus
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
		this.ballSpeedInit = 4;
		this.dx = this.ballSpeedInit;
		this.dy = -this.ballSpeedInit;
		this.ballRadius = 8;

		// Paddle
		this.paddleWidth = 75;
		this.paddleX = (this.canvas.width-this.paddleWidth)/2;

		// Vies
		this.lives = 2;

		// Bonus
		this.bonus = 1.25;

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
		this.ballSpeedInit = 5;
		this.dx = this.ballSpeedInit;
		this.dy = -this.ballSpeedInit;
		this.ballRadius = 6;

		// Paddle
		this.paddleWidth = 50;
		this.paddleX = (this.canvas.width-this.paddleWidth)/2;

		// Vies
		this.lives = 1;

		// Bonus
		this.bonus = 1.5;

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
		                this.brickBreaked++;
		                this.score = this.score + (100*this.bonus)*this.combo;
		                this.combo++;
		                if(this.brickBreaked == this.brickRowCount*this.brickColumnCount) {
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
	    this.ctx.fillStyle = this.color;
	    this.ctx.fillText("Score: "+this.score, 8, 20);
	}

	// Affiche le nombre de vies
	drawLives() {
	    this.ctx.font = "16px Arial";
	    this.ctx.fillStyle = this.color;
	    this.ctx.fillText("Lives: "+this.lives, this.canvas.width-65, 20);
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
		            this.ctx.fillStyle = this.brickColors[i];
		            if (i < this.brickColors.length-1) {
		            	i++
		            } else {
		            	i = 0;
		            }
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
				if (this.rightPressed) {
					this.dx = this.dx + 1;
				} else if (this.leftPressed) {
					this.dx = this.dx - 1;
				}
		        this.dy = -this.dy;
		        this.combo = 1;
		    } else {
			    this.lives--;
				if(!this.lives) {
				    alert("GAME OVER");
				    document.location.reload();
				}
				else {
				    this.x = this.canvas.width/2;
				    this.y = this.canvas.height-30;
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
	    	this.paddleX += 7;
		}
		else if(this.leftPressed && this.paddleX > 0) {
		    this.paddleX -= 7;
		}

		this.x += this.dx;
		this.y += this.dy;
		requestAnimationFrame(this.draw.bind(this));
	}

	// Formulaire en cas de victoire
	/*winningForm() {
		this.winForm = document.createElement("form");
		this.winForm.classList.add("p-4", "rounded");
		this.winForm.setAttribute("action", "index.php");

		this.winInputLabel = document.createElement("label");
		this.winInputLabel.classList.add("font-weight-bold");
		this.winInputLabel.setAttribute("for", "winnerName");

		this.winInput = document.createElement("label");
		this.winInput.classList.add("form-control");
		this.winInput.setAttribute("id", "winnerName");
		this.winInput.setAttribute("name", "winnerName");
		this.winInput.setAttribute("maxlength", "3");

		this.winButton = document.createElement("button");
		this.winButton.setAttribute("type", "submit");

		this.winForm.appendChild(this.winInputLabel);
		this.winForm.appendChild(this.winInput);
		this.winForm.appendChild(this.winButton);

		this.gameElt.removeChild(this.canvas);
		this.gameElt.appendChild(this.winForm);
	}*/
}

//Construit la carte à la fin du chargement de la page
window.addEventListener("load", function(){
	const casseBrique = new brickBreaker("myCanvas");
});