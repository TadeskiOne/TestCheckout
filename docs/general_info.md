# General

The fundamental idea underlying the architecture of the solution for commission calculation is the structuring of logic into several layers.
The current implementation is distinctly separated into three tiers:

 - **Scenario layer**: the logic for determining the criteria for applying a specific set of rules and operations to a transaction. It defines specific conditions and criteria that a transaction must meet to apply calculations; it contains a list of rules and conditions for their application to the transaction.
 - **Rule layer**: the logic for directly processing transactions. Each rule is universal and can be applied to any transaction. The transactions to which specific rules should be applied are determined by the scenario.
 - **Mathematics layer**: the logic for performing mathematical operations on transactions. It contains primitive strategies for applying mathematical formulas to transactions. For example, if a rule specifies that 5% should be added to the transaction amount as a margin, the logic encapsulated at this level will first calculate the margin percentage and then add it to the transaction amount.

This structure is quite flexible and allows the creation of different sets of tools for working with transactions while maintaining a homogeneous structure between sets. It enables the rapid and flexible development of new sets or the extension of existing ones.

In this structure, only the scenario and rule layers are standardized. The mathematics layer is conditional and local to a specific toolkit, so for some processes, a separate mathematics handler may not be necessary, while in others, multiple layers of mathematics may be needed.

There is no need to implement all these layers in a new toolkit, but the scenario layer must be present. That is, if a new toolkit does not involve extensive branching of processes over transactions, which can be described as separate rules, all logic can be encapsulated in a scenario.

However, the architecture allows bypassing the use of scenarios, but it is not recommended to do so, as, as mentioned above, the scenario should define the criteria by which rules will be applied to transactions or encapsulate logic within scenarios. This structure clearly delineates responsibilities between layers, so avoiding the implementation of higher layers of logic will complicate the implementation of a new toolkit into the application.

It is recommended to add a separate method to the ValuationService for each new scenario. However, it is entirely possible to separate the use of a specific set of tools into a separate service.