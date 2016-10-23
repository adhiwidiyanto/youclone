<template>
	<div class="video__voting">
		<a href="#" class="video__voting-button" v-bind:class="{'video__voting-button--voted': userVote == 'up'}" @click.prevent="vote('up')">
			<span class="glyphicon glyphicon-thumbs-up"></span>
		</a> {{ up }} &nbsp;

		<a href="#" class="video__voting-button" v-bind:class="{'video__voting-button--voted': userVote == 'down'}" @click.prevent="vote('down')">
			<span class="glyphicon glyphicon-thumbs-down"></span>
		</a> {{ down }}
	</div>
</template>

<script>
	export default {
		data(){
			return {
				up: null,
				down: null,
				userVote: null,
				canVote: false
			}
		},

		methods: {
			getVotes() {
				this.$http.get('/videos/' + this.videoUid + '/votes').then((response) => {
					this.up = response.body.data.up;
					this.down = response.body.data.down;
					this.userVote = response.body.data.user_vote;
					this.canVote = response.body.data.can_vote;
				});
			},
			vote (type){
				if (this.userVote == type) {
					this[type]--;
					this.userVote = null;
					this.deleteVote(type);
					return;
				}

				if (this.userVote) {
					this[type == 'up' ? 'down' : 'up']--;
				}

				this[type]++;
				this.userVote = true;

				this.createVote(type);
			},
			deleteVote(type){
				this.$http.delete('/videos/' + this.videoUid + '/votes');
			},
			createVote(type){
				this.$http.post('/videos/' + this.videoUid + '/votes',{
					type: type
				});
			}
		},

		props: {
			videoUid: null
		},

		ready(){
			this.getVotes()
		}
	}
</script>