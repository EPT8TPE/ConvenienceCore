# ConvenienceCore
A pocketmine-mp plugin that implements a number of commands all into one plugin!

# Current commands:
- /clearinventory
- /enderchest [echest]
- /fly
- /feed
- /heal
- /setlore
- /rename

## Permissions:

  fly.allow:
  
    description: Allows players to use the /fly command.
    default: op

  feed.allow:
  
    default: op
    description: Allows players to use the /feed command.

  heal.allow:
  
    default: op
    description: Allows players to use the /heal command.

  setlore.allow:
  
    default: op
    description: Allows players to use the /setlore commmand.

  rename.allow:
  
    default: op
    description: Allows players to use the /rename command.

  clearinv.allow:
  
    default: op
    description: Allows players to use the /clearinventory command.

  enderchest.allow:
  
    default: op
    description: Allows players to access their enderchest with the /ec or /enderchest command.
    
 ## Config
 
 ### Almost everthing in this plugin is configurable!
 
 ### Set to true if you want a specific feature disabled.

fly-feature-disabled: false

setlore-feature-disabled: false

heal-feature-disabled: false

feed-feature-disabled: false

rename-feature-disabled: false

clearinv-feature-disabled: false

enderchest-feature-disabled: false

### Messages sent to players if feature-disabled is set to true.

setlore-feature-disabled-message: "§cThis command has been disabled!"

fly-feature-disabled-message: "§cThis command has been disabled!"

heal-feature-disabled-message: "§cThis command has been disabled!"

rename-feature-disabled-message: "§cThis command has been disabled!"

feed-feature-disabled-message: "§cThis command has been disabled!"

clearinv-feature-disabled-message: "§cThis command has been disabled!"

enderchest-feature-disabled-message: "§cThis command has been disabled!"

### Messages sent to player when certain commands have ran/tasks completed.

message-sent-to-player-on-flight-enable: "(§l!§r)§l§eFlight has been enabled!"

message-sent-to-player-on-flight-disable: "(§l!§r)§l§eFlight has been disabled!"

message-sent-to-player-when-fed: "(§l!§r)§l§3You have been saturated!"

message-sent-to-player-when-healed: "(§l!§r)§l§aHealth restored!"

message-sent-to-player-when-setlore: "(§l!§r)§d§lItem lore changed successfully!"

message-sent-to-player-when-rename: "(§l!§r)§b§lItem name changed successfully!"

message-sent-to-player-when-clearinv: "(§l!§r)§9§lInventory cleared successfully!"

### Message sent to player if they lack the permissions to run a certain command.

no-perms-message-feed: "§cYou do not have permission to use this command!"

no-perms-message-fly: "§cYou do not have permission to use this command!"

no-perms-message-setlore: "§cYou do not have permission to use this command!"

no-perms-message-heal: "§cYou do not have permission to use this command!"

no-perms-message-rename: "§cYou do not have permission to use this command!"

no-perms-messages-clearinv: "§cYou do not have permission to use this command!"

no-perms-message-enderchest: "§cYou do not have permission to use this command!"

### Messages sent to player if their hands are empty and they run the commands below.

message-sent-to-player-when-hand-is-empty-setlore: "§cYou must hold an item while running this command!"

message-sent-to-player-when-hand-is-empty-rename: "§cYou must hold an item while running this command!"

### Set this to false if you want players to be able to fly during pvp.

flight-disabled-on-hit: true

### Message sent to player if they attempt to fly during combat when flight disabled on hit is set to true.

no-flight-during-combat-message: "(§l!§r)§cFlying during combat is not permitted!"

### Text viewable to player just above the hotbar as enderchest opens.

pop-up-message-enderchest: "§l§aOpening enderchest..."

### Issues:
- If flight-disabled-on-hit is set to true and a player hits another player, their flight will be disabled, however in order to reactivate flight they have to run the command /fly twice, I know this is bugged and am working on it which is why I have given you the choice to disable all the features of thee plugin :).

Contact me on discord: TPE#3107 for suggestions and any errors you find!

[![](https://poggit.pmmp.io/shield.state/ConvenienceCore)](https://poggit.pmmp.io/p/ConvenienceCore)
<a href="https://poggit.pmmp.io/p/ConvenienceCore"><img src="https://poggit.pmmp.io/shield.state/ConvenienceCore"></a>
 


