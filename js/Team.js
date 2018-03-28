function Team() {
    this.controller = 'Team';
    this.template = new Template('template-team');
    //this.$el = this.assemble();
}

// set this object to inherit from core
Team.prototype = Object.create(Core.prototype);
Team.prototype.constructor = Team;

$.extend(Team.prototype, {
    // assigns the data to the template
    assemble: function(result) {
        console.log(result);  
        this.$el =  this.template.
        assign({
            'team-name': result.TeamName,
        }).
        assemble();

        return this;
    },
    appendTo: function (workspace) {
        workspace.append(this);
    },
    dom: function() {
        return this.$el;
    },
    addPlayer: function (player) {
        this.roster.push(player);
        this.assembleRoster();
    },
    assembleRoster: function() {
        var $players = this.template.retrieve('players');
        $players.empty();
        $.each(this.roster, (index, player) => {
            player.dom().appendTo($players);
        });
    },

    buildRoster: function (rosterData) {
        $.each(rosterData, (index, playerData) => {
            var player = new Player(playerData['player-name'], playerData.position, playerData.points);
            this.roster.push(player);
        });

        this.assembleRoster();

    }

});