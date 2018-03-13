function Workspace($el) {
    this.$el = $el;
    return this;
}

$.extend(Workspace.prototype, {
    append: function(content){
        this.dom().append(content.dom());
    },
    dom: function() {
        return this.$el;
    }
});

function Team(name, roster) {
    this.name = name;
    this.roster = roster;
    this.template = new Template('template-team');
    this.$el = this.assemble();
    this.buildRoster();
}

$.extend(Team.prototype, {
    // assigns the data to the template
    assemble: function() {
        return this.template.
        assign({
            'team-name': this.name,
        }).
        assemble();
    },
    appendTo: function (workspace) {
        workspace.append(this);
    },
    dom: function() {
        return this.$el;
    },
    addPlayer: function (player) {
        player.dom().appendTo(this.dom().find('.players'));
    },
    buildRoster: function() {
        $.each(this.roster, (index, playerData) => {
            var player = new Player(playerData['player-name'], playerData.position, playerData.points);
            this.addPlayer(player);
        });
    }

});

function Player(name, position, points){
    this.name = name;
    this.position = position;
    this.points = points;
    this.template = new Template('template-player');
    this.$el = this.assemble();
}

$.extend(Player.prototype, {
    assemble: function() {
        return this.template.
        assign({
            'player-name': this.name,
            'position': this.position,
            'points': this.points
        }).
        assemble();
    },
    addToTeam: function(team) {
        team.addPlayer(this);
    },
    dom: function() {
        return this.$el;
    }

});